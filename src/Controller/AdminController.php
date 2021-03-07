<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Plats;
use App\Entity\Restaurant;
use App\Form\PlatsType;
use App\Form\RestaurantType;
use App\Repository\CategorieRepository;
use App\Repository\MenuRepository;
use App\Repository\PlatsRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/restaurants/list/", name="restaurants_list")
     */
    public function showAll(RestaurantRepository $reposs, SessionInterface $session): Response
    {
        $resto = $reposs->findAll();
        return $this->render('restaurants/list.html.twig', [
            'restau' => $resto,
        ]);
    }


    /**
     * Permet d'afficher un restaurant a partie de son nom
     * @Route ("admin/restaurant/{libelle}", name="show_resto_admin")
     *
     */
    public function show($libelle, RestaurantRepository $repos,  PlatsRepository $plat): Response
    {
        // trouver un restaurant a partirss d'une libelle
        $resto = $repos->findOneByLibelle($libelle);
        $menus = $resto->getMenus();
        $plats = $plat->findAll();
        return $this->render('restaurants/show.html.twig',
            ['resto' => $resto,
                'menu' =>$menus,
                'plat' => $plats
            ] );

    }


//ajouter un resto
    /**
     * Permet d'afficher un restaurant a partie de son nom
     * @Route ("admin/restaurants/add/", name="add_resto")
     */
    public function add(Request $request, RestaurantRepository $repos): Response
    {
        $Modele = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $Modele);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $Modele->getImage();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $Modele->setImage($filename);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Modele);
            $entityManager->flush();
            $this->addFlash('success', "Les données du restaurant ont élé enregistré avec succés !");
            return $this->redirect($this->generateUrl("restaurants_list"));

        }

        return $this->render('restaurants/add.html.twig',
            array(
                'Form' => $form->createView()
            ));

    }

// supprimer un resto
    /**
     * Permet d'afficher un restaurant a partie de son nom
     * @Route ("admin/restaurants/delete/{id}", name="delete_resto")
     */
    public function deleteResto(Request $request, $id , RestaurantRepository $repos): Response
    {
        $resto = $repos->find($id);
        $em= $this->getDoctrine()->getManager();
        if ($resto!==null)
        {
            $em->remove($resto);
            $em->flush();
        }
        else
        {
            throw new NotFoundHttpException("Le restaurant d'id".$id."n'existe pas");
        }

        return $this->redirect($this->generateUrl("restaurants_list"));    }

//Mettre à jour un resto
    /**
     * Permet d'afficher un restaurant a partie de son nom
     * @Route ("admin/restaurants/update/{id}", name="update_resto")
     */
    public function update(Request $request, $id, RestaurantRepository $repos):Response
    {
        $resto = $repos->find($id);
        $editform = $this->createForm(RestaurantType::class, $resto);
        $editform->handleRequest($request);
        $image = $resto->getImage();

        if ($editform->isSubmitted() && $editform->isValid())
        {
            if ( $resto->getImage() !=null ){
                $resto->setImage(
                    new File($this->getParameter('image_directory') . '/' . $resto->getImage())
                );
            }else { // aucune nouvelle image envoyée
                //on recupère l'ancienne image
                $resto->setImage($image);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($resto);
            $em->flush();
            return $this->redirect($this->generateUrl("restaurants_list"));        }

        return $this->render('restaurants/update.html.twig',
            [
                'editForm'=>$editform->createView(),
                'resto'=>$resto
            ]);
    }


    /**
     * index des plats
     * @Route("/admin/plats", name="list_plats", methods={"GET","HEAD"})
     */
    public function plats(PlatsRepository $repos, SessionInterface $session): Response
    {
        // $repos = $this->getDoctrine()->getRepository(Restaurant::class);
        dump($session);
        $plats = $repos->findAll();
        return $this->render('admin/liste-plats.html.twig', [
            'plats' => $plats,
        ]);
    }


    //ajouter un plat
    /**
     * Permet d'afficher un restaurant a partie de son nom
     * @Route ("admin/plats/add/", name="add_plat")
     */
    public function addPlat(Request $request, PlatsRepository $repos): Response
    {
        $Modele = new Plats();
        $form = $this->createForm(PlatsType::class, $Modele);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Modele);
            $entityManager->flush();
            $this->addFlash('success', "Les données du plat ont élé enregistré avec succés !");
            return $this->redirect($this->generateUrl("list_plats"));

        }


        return $this->render('restaurants/addPlats.html.twig',
            array(
                'Form' => $form->createView()
            ));

    }


    /**
     * Permet d'afficher un restaurant a partie de son nom
     * @Route ("admin/plats/update/{id}", name="update_plat")
     */
    public function updatePlat(Request $request, $id, PlatsRepository $repos):Response
    {
        $plat = $repos->find($id);
        $editform = $this->createForm(PlatsType::class, $plat);
        $editform->handleRequest($request);
        if ($editform->isSubmitted() && $editform->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plat);
            $em->flush();
            return $this->redirect($this->generateUrl("list_plats"));        }

        return $this->render('restaurants/updatePlat.html.twig',
            [
                'editForm'=>$editform->createView()
            ]);
    }

// supprimer un resto
    /**
     * Permet d'afficher un restaurant a partie de son nom
     * @Route ("admin/plat/delete/{id}", name="delete_plat")
     */
    public function deletePlat(Request $request, $id , PlatsRepository $repos): Response
    {
        $plat = $repos->find($id);
        $em= $this->getDoctrine()->getManager();
        if ($plat!==null)
        {
            $em->remove($plat);
            $em->flush();
        }
        else
        {
            throw new NotFoundHttpException("Le plat d'id".$id."n'existe pas");
        }

        return $this->redirect($this->generateUrl("list_plats"));    }
}
