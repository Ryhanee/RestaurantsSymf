<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;




class HomeController extends Controller{

/**
 * @Route("/", name="homepage")
 */
    public function home(){
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/admin", name="dashboard")
     */
    public function dashboard(){
        return $this->render('/dashboard.html.twig');
    }
}



?>
