<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\MenuRepository;
use App\Repository\PlatsRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        if ($editform->isSubmitted() && $editform->isValid())
        {
            $file = $resto->getImage();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $resto->setImage($filename);
            $em = $this->getDoctrine()->getManager();
            $em->persist($resto);
            $em->flush();
            return $this->redirect($this->generateUrl("restaurants_list"));        }

        return $this->render('restaurants/update.html.twig',
            [
                'editForm'=>$editform->createView()
            ]);
    }

//ajouter menu

    public function addMenu(Request $request)
    {
        $menu = new Menu();
        $form = $this->createForm(MenuForm::class, $menu);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid())
        {
            $em= $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();

            return $this->redirect($this->generateUrl("affichage_menu"));
        }

        return $this->render('@Resto/ModeleMenu/add.html.twig',
            array(
                'Form'=>$form->createView()
            ));
    }
// supprimer un Menu

    public function deleteMenu(Request $request, $id, MenuRepository $menuRepo)
    {

        $em= $this->getDoctrine()->getManager();
        $menu = $menuRepo->find($id);
        if ($menu!==null)
        {
            $em->remove($menu);
            $em->flush();
        }
        else
        {
            throw new NotFoundHttpException("Le menu d'id".$id."n'existe pas");
        }

        return $this->redirectToRoute("affichage_menu");
    }
//Mettre à jour un menu

    public function updateMenu(Request $request, $id, MenuRepository $menurepo)
    {
        $em= $this->getDoctrine()->getManager();
        $Menu=$menurepo->find($id);

        $editform = $this->createForm(MenuForm::class, $Menu);
        $editform->handleRequest($request);

        if ($editform->isSubmitted() && $editform->isValid())
        {
            $em->persist($Menu);
            $em->flush();
            return $this->redirect($this->generateUrl("affichage_menu"));
        }

        return $this->render('@Resto/ModeleMenu/update.html.twig',
            array(
                'editForm'=>$editform->createView()
            ));
    }

    /**
     * index des restaurants
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

}
