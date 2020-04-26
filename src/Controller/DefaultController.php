<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function loginAction(AuthenticationUtils $auth)
    {
        $error = $auth->getLastAuthenticationError();

        $lastUsername = $auth->getLastUsername();

        return $this->render('Usuarios/login.html.twig',
            array(
                'last_username' => $lastUsername,
                'error' => $error,
            )
        );
    }
}
