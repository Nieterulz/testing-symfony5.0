<?php

namespace App\Controller;

use App\Entity\Articulos;
use App\Form\ArticulosType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticulosController extends AbstractController
{
    /**
     * @Route("/articulos", name="articulos")
     */
    public function index()
    {
        $articulosRespository = $this->getDoctrine()->getRepository(Articulos::class);
        $articulos = $articulosRespository->findAll();

        return $this->render('Articulos/mostrarTodos.html.twig',
            array('articulos' => $articulos));
    }

    /**
     * @Route("/{id}", name="mostrar_un_articulo")
     */
    public function mostrarArticulo($id)
    {
        $articulosRespository = $this->getDoctrine()->getRepository(Articulos::class);
        $articulo = $articulosRespository->find($id);

        return $this->render('Articulos/unArticulo.html.twig',
            array('art' => $articulo));
    }

    /**
     * Route("/nuevo/Articulo", name="insertar_articulo")
     */
    public function nuevoArticulo(Request $request)
    {
        $articulos = new Articulos();

        //Construyendo el formulario
        $form = $this->createForm(ArticulosType::class, $articulos);
        //Recogemos la información
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Rellenar la entidad articulos
            $articulos = $form->getData();
            // Almacenar nuevo articuo
            $em = $this->getDoctrine()->getManager();
            $em->persist($articulos);
            $em->flush();

            return $this->redirectToRoute("mostrar_un_articulo", array('id' => $articulos->getId()));
        }
        return $this->render('Articulos/nuevoArticulo.html.twig', array('form' => $form->createView()));
    }
}
