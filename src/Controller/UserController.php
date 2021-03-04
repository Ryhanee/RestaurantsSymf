<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     *
     * @Route("/user/{username}", name="user_show")
     */
    public function index(User $user): Response
    {
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     *
     * @Route("/account", name="user_show")
     */
    public function account(User $user): Response
    {
        return $this->render('user/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }
}
