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
        $menus = $menu->findAll($menu);
        $cats = $cat->findAll($cat);
        $plats = $plat->findAll();
        return $this->render('restaurants/show.html.twig',
            ['resto' => $resto,
                'menu' =>$menus,
                'cats' => $cats,
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



    //Recherche Plat
    public function searchAction(Request $request, MenuRepository $menurepo){
        $em = $this->container->get('doctrine')->getEntityManager();

        $menus = $menurepo->findAll();
        if($request->getMethod("POST")){
            $motclemenu=$request->get('input_recherche');
            $query=$em->createQuery(
                "SELECT m FROM Entity:Menu m WHERE m.categorie LIKE '".$motclemenu."%'"
            );
            $plats=$query->getResult();
        }
        return $this->render('@Resto/ModeleMenu/search.html.twig',
            array(
                'menus'=>$menus
            ));
    }


    //ajouter un plat
    /**
     * Permet d'afficher un restaurant a partie de son nom
     * @Route ("/plats/add/", name="add_plat")
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
                return $this->redirect($this->generateUrl("restaurants_list"));

            }


        return $this->render('restaurants/addPlats.html.twig',
            array(
                'Form' => $form->createView()
            ));

    }

}
