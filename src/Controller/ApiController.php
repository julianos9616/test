<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//Importación de las entidades para operar sobre ellas
use App\Entity\Product;
use App\Entity\Customer;
use App\Entity\Sale;

//Importación doctrine
use Doctrine\Persistence\ManagerRegistry;

//Importaciones necesarias para trabajar con los formularios
use Symfony\Component\HttpFoundation\Request;
//Importación para creación de un formulario que no tiene relación con una entidad en particualr
use Symfony\Component\Form\FormBuilderInterface;
//Importación para hacer uso del boton submit en formulario que no tiene relación con una entidad en particular
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    #[Route('/api/detalle/{codigoProducto}', name: 'api_codigo')]
    public function busquedaCodigo(ManagerRegistry $doctrine,$codigoProducto): Response
    {
        $entityManager = $doctrine->getManager();
        $product =  $entityManager->getRepository(Product::class)->findOneBy(['codigo'=>$codigoProducto]);
        // dd($product);
        return $this->render('api/infoProduct.html.twig',array('producto'=>$product));
    }

    #[Route('/api/stock', name: 'api_stock')]
    public function stockProducto(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $product =  $entityManager->getRepository(Product::class)->findAll();

        return $this->render('api/stockProduct.html.twig',array('products'=>$product));
    }

    #[Route('/api/searchProduct', name: 'api_search')]
    public function buscarProducto(ManagerRegistry $doctrine,Request $request): Response
    {
        $form  = $this->createFormBuilder()
            ->add('codigo_producto')
            ->add('Buscar',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $doctrine->getManager();
            $data = $form->getData();
            $entityManager = $doctrine->getManager();
            $product =  $entityManager->getRepository(Product::class)->findOneBy(['codigo'=>$data['codigo_producto']]);
            $entityManager->flush();
            return $this->redirectToRoute('api_codigo',array('codigoProducto'=>$product));
        }

        return $this->render('/api/searchProduct.html.twig',array('form'=>$form->createView()));
    }
}
