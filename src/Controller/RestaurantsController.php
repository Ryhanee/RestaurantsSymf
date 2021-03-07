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
use RestoBundle\Form\PlatType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\String\AbstractUnicodeString;


class RestaurantsController extends AbstractController
{
    /**
     * index des restaurants
     * @Route("/restaurants/", name="resto_list", methods={"GET","HEAD"})
     */
    public function index(RestaurantRepository $repos, SessionInterface $session): Response
    {
        // $repos = $this->getDoctrine()->getRepository(Restaurant::class);
        dump($session);
        $resto = $repos->findAll();
        return $this->render('restaurants/index.html.twig', [
            'restos' => $resto,
        ]);
    }

    /**
     * Permet d'afficher un restaurant a partie de son nom
     * @Route ("/restaurant/{libelle}", name="show_resto")
     *
     */
    public function show($libelle, RestaurantRepository $repos, MenuRepository $menu, PlatsRepository $plat, CategorieRepository $cat): Response
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

    /**
     * @Route("/restaurants/", name="restaurants_search")
     * @return Response
     */
    //Recherche Resto
    public function search(Request $request, RestaurantRepository $repos): Response{
        $resto = $repos->findAll();
        if($request->getMethod("POST")){
            $em = $this->getDoctrine()->getManager();
            $motcle=$request->get('input_recherche');
            $query=$em->createQuery(
                "SELECT m FROM App\Entity\Restaurants m WHERE m.libelle LIKE '".$motcle."%'"
            );
            $resto=$query->getResult();
        }
        return $this->render('restaurants/index.html.twig',
            [
                'restau'=>$resto
            ]);
    }



}
