<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Form\UsuariosType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UsuariosController extends AbstractController
{
    public function registroAction(Request $request)
    {
        $usuarios = new Usuarios();

        //Construyendo el formulario
        $form = $this->createForm(UsuariosType::class, $usuarios);
        //Recogemos la información
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Rellenar la entidad usuarios
            $usuarios = $form->getData();
            // Almacenar nuevo usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuarios);
            $em->flush();

            return $this->redirectToRoute("homepage", array('usuario' => $usuarios));
        }
        return $this->render('Usuarios/registro.html.twig', array('form' => $form->createView()));
    }
}
