<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAccountController extends AbstractController
{
    /**
     * @Route("/admin/login", name="admin_account")
     */
    public function login(): Response
    {
        return $this->render('admin/admin_account/index.html.twig', [
            'controller_name' => 'AdminAccountController',
        ]);
    }
}
