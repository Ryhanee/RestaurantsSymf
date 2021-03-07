<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Restaurant;
use App\Form\MenuType;
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

class MenuController extends AbstractController
{
    /**
     * @Route("/admin/menus/list/", name="menu_list")
     */
    public function showAll(MenuRepository $reposs, SessionInterface $session): Response
    {
        $menu = $reposs->findAll();
        return $this->render('menu/index.html.twig', [
            'menus' => $menu,
        ]);
    }
    /**
     * Permet d'afficher un restaurant a partie de son nom
     * @Route ("/menu/{libelle}", name="show_menu")
     *
     */
    public function show($libelle, MenuRepository $menu, PlatsRepository $plat, CategorieRepository $cat): Response
    {
        // trouver un restaurant a partirss d'une libelle
        $menu = $menu->findOneByLibelle($libelle);
        $plats = $menu->getPlats();
        return $this->render('menu/show.html.twig',
            ['menu' => $menu,
                'plats' => $plats
            ] );

    }
//ajouter un menu
    /**
     * Permet d'afficher un restaurant a partie de son nom
     * @Route ("admin/menu/add/", name="add_menu")
     */
    public function add(Request $request, MenuRepository $repos): Response
    {
        $Modele = new Menu();
        $form = $this->createForm(MenuType::class, $Modele);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Modele);
            $entityManager->flush();
            $this->addFlash('success', "Les données du menu ont élé enregistré avec succés !");
            return $this->redirect($this->generateUrl("menu_list"));

        }

        return $this->render('menu/add.html.twig',
            array(
                'Form' => $form->createView()
            ));

    }

// supprimer une menu
    /**
     * Permet d'afficher un restaurant a partie de son nom
     * @Route ("admin/menu/delete/{id}", name="delete_menu")
     */
    public function deleteMenu($id , MenuRepository $repos): Response
    {
        $menu = $repos->find($id);
        $em= $this->getDoctrine()->getManager();
        if ($menu!==null)
        {
            $em->remove($menu);
            $em->flush();
        }
        else
        {
            throw new NotFoundHttpException("Le menu d'id".$id."n'existe pas");
        }

        return $this->redirect($this->generateUrl("menu_list"));    }

//Mettre à jour une menu
    /**
     * Permet d'afficher un restaurant a partie de son nom
     * @Route ("admin/menu/update/{id}", name="update_menu")
     */
    public function update(Request $request, $id, MenuRepository $repos):Response
    {
        $menu = $repos->find($id);
        $editform = $this->createForm(MenuType::class, $menu);
        $editform->handleRequest($request);

        if ($editform->isSubmitted() && $editform->isValid())
        {

            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();
            return $this->redirect($this->generateUrl("menu_list"));        }

        return $this->render('menu/update.html.twig',
            [
                'editForm'=>$editform->createView()
            ]);
    }

  }
