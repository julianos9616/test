<?php




namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//Importación de las entidades para operar sobre ellas
use App\Entity\Product;
use App\Entity\Customer;
use App\Entity\Sale;
// use App\Entity\Compra;

//Importación doctrine
use Doctrine\Persistence\ManagerRegistry;

//Importaciones necesarias para trabajar con los formularios
use Symfony\Component\HttpFoundation\Request;
//Importación para creación de un formulario que no tiene relación con una entidad en particualr
use Symfony\Component\Form\FormBuilderInterface;
//Importación para hacer uso del boton submit en formulario que no tiene relación con una entidad en particular
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    // =====================================================================================
    // ============================== START CRUD CUSTOMER ==================================
    // =====================================================================================


    // ******************************* Metodo para listar clientes **************************** //
    #[Route('/test/customer/listar', name: 'customer_listar')]
    public function listar(ManagerRegistry $doctrine): Response
    {
        
        $entityManager = $doctrine->getManager();
        $customers =  $entityManager->getRepository(Customer::class)->findAll();
        
        return $this->render('test/customer/customerListar.html.twig',array('customers'=>$customers));
    }

    // ******************************* Metodo para crear clientes ***************************** //
    #[Route('/test/customer/crear', name: 'customer_crear')]
    public function crear(ManagerRegistry $doctrine,Request $request): Response
    {
        
        // Creacion formulario
        $form = $this->createFormBuilder()
            ->add('documento')
            ->add('nombres')
            // ->add('sale',EntityType::class)
            ->add('sale',EntityType::class,[
                'class' =>Sale::class,
                'choice_label' => function ($sale) {
                return $sale->getNombreTienda();
            }
        ])
        ->add('Crear',SubmitType::class)
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

                $entityManager = $doctrine->getManager();
                
                //Asociación de los atributos del formulario
                $data = $form->getData();
                // $sale = new Sale($data['sale']);
                $customer = new Customer($data['documento'],$data['nombres']);
                $customer->setSale($data['sale']);

                $entityManager->persist($customer);
                // $entityManager->persist($sale);
                $entityManager->flush();
                return $this->redirectToRoute('app_test',);
        }
        // $entityManager = $doctrine->getManager();
        // $sale = new Sale('Mercamas');
        // $customer = new Customer('4563','Juan Esteban');
        // $customer->setSale($sale);
        // $entityManager->persist($sale);
        // $entityManager->persist($customer);
        // $entityManager->flush();
        // return $this->render('test/customerOperationOk.html.twig',);
        return $this->render('/test/customer/customerCrear.html.twig',array('form'=>$form->createView()));
    }

    // ******************************* Metodo para eliminar clientes ***************************** //
    #[Route('/test/customer/eliminar', name: 'customer_borrar')]
    public function eliminar(ManagerRegistry $doctrine,Request $request): Response
    {
        
        // Creacion formulario
        $form = $this->createFormBuilder()
            ->add('idCliente')
            ->add('Eliminar',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

                $entityManager = $doctrine->getManager();
                $data = $form->getData();
                $customer =  $entityManager->getRepository(Customer::class)->find($data['idCliente']);
                $entityManager->remove($customer);
                $entityManager->flush();
                return $this->redirectToRoute('app_test',);
        }

        return $this->render('/test/customer/customerEliminar.html.twig',array('form'=>$form->createView()));

        // $entityManager = $doctrine->getManager();
       
        // $customer =  $entityManager->getRepository(Customer::class)->find(10);

        // $entityManager->remove($customer);
        // $entityManager->flush();
        
        // return $this->render('test/customerOperationOk.html.twig',);
    }

    // ******************************* Metodo para actualizar clientes ***************************** //
    #[Route('/test/customer/actualizar', name: 'customer_actualizar')]
    public function actualizar(ManagerRegistry $doctrine,Request $request): Response
    {
        // Creacion formulario
        $form = $this->createFormBuilder()
            ->add('idCliente')
            ->add('documento')
            ->add('nombres')
            ->add('Actualizar',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

                $entityManager = $doctrine->getManager();
                $data = $form->getData();
                $customer =  $entityManager->getRepository(Customer::class)->find($data['idCliente']);
                $customer->setDocumento($data['documento']);
                $customer->setNombres($data['nombres']);
                $entityManager->flush();
                return $this->redirectToRoute('app_test',);
        }

        return $this->render('/test/customer/customerActualizar.html.twig',array('form'=>$form->createView()));
        // $entityManager = $doctrine->getManager();
        // $customer =  $entityManager->getRepository(Customer::class)->find(8);
        // $customer->setDocumento('1088025');
        // $customer->setNombres('Yuliana');
        // $entityManager->persist($customer);
        // $entityManager->flush();
    
        // return $this->render('test/customerOperationOk.html.twig',);
    }

    // =====================================================================================
    // ============================== END CRUD CUSTOMER ===================================
    // =====================================================================================


    // =====================================================================================
    // ============================== START CRUD PRODUCT ==================================
    // =====================================================================================


    // ******************************* Metodo para listar productos **************************** //
    #[Route('/test/product/listar', name: 'product_listar')]
    public function listarProducto(ManagerRegistry $doctrine): Response
    {
        
        $entityManager = $doctrine->getManager();
        $product =  $entityManager->getRepository(Product::class)->findAll();
        
        return $this->render('test/product/productListar.html.twig',array('products'=>$product));
    }

    // ******************************* Metodo para crear productos ***************************** //
    #[Route('/test/product/crear', name: 'product_crear')]
    public function crearProducto(ManagerRegistry $doctrine,Request $request): Response
    {
        
        // Creacion formulario
        $form = $this->createFormBuilder()
            ->add('codigo')
            ->add('nombre')
            ->add('stock')
            ->add('precio')
            ->add('cantidad')
        ->add('Crear',SubmitType::class)
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
                $entityManager = $doctrine->getManager();
                $data = $form->getData();
                $product = new Product($data['codigo'],$data['nombre'],$data['stock'],$data['precio'],$data['cantidad']);

                $entityManager->persist($product);
                $entityManager->flush();
                return $this->redirectToRoute('app_test',);
        }
        return $this->render('/test/product/productCrear.html.twig',array('form'=>$form->createView()));
    }

    // ******************************* Metodo para eliminar clientes ***************************** //
    #[Route('/test/product/eliminar', name: 'product_borrar')]
    public function eliminarProducto(ManagerRegistry $doctrine,Request $request): Response
    {
        
        // Creacion formulario
        $form = $this->createFormBuilder()
            ->add('idProducto')
            ->add('Eliminar',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

                $entityManager = $doctrine->getManager();
                $data = $form->getData();
                $producto =  $entityManager->getRepository(Product::class)->find($data['idProducto']);
                $entityManager->remove($producto);
                $entityManager->flush();
                return $this->redirectToRoute('app_test',);
        }

        return $this->render('/test/product/productEliminar.html.twig',array('form'=>$form->createView()));
    }

    // ******************************* Metodo para actualizar clientes ***************************** //
    #[Route('/test/product/actualizar', name: 'product_actualizar')]
    public function actualizarProducto(ManagerRegistry $doctrine,Request $request): Response
    {
        // Creacion formulario
        $form = $this->createFormBuilder()
            ->add('idProducto')
            ->add('codigo')
            ->add('nombre')
            ->add('stock')
            ->add('precio')
            ->add('cantidad')
            ->add('Actualizar',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

                $entityManager = $doctrine->getManager();
                $data = $form->getData();
                $product =  $entityManager->getRepository(Product::class)->find($data['idProducto']);
                $product->setCodigo($data['codigo']);
                $product->setNombre($data['nombre']);
                $product->setStock($data['stock']);
                $product->setPrecio($data['precio']);
                $product->setCantidad($data['cantidad']);
                $entityManager->flush();
                return $this->redirectToRoute('app_test',);
        }

        return $this->render('/test/product/productActualizar.html.twig',array('form'=>$form->createView()));
    }

    // =====================================================================================
    // ============================== END CRUD PRODUCT ===================================
    // =====================================================================================
    
    // =====================================================================================
    // ============================== START CRUD SALE ==================================
    // =====================================================================================


    // ******************************* Metodo para listar productos **************************** //
    #[Route('/test/sale/listar', name: 'sale_listar')]
    public function listarTienda(ManagerRegistry $doctrine): Response
    {
        
        $entityManager = $doctrine->getManager();
        $sale =  $entityManager->getRepository(Sale::class)->findAll();
        
        return $this->render('test/sale/saleListar.html.twig',array('sales'=>$sale));
    }

    // ******************************* Metodo para crear productos ***************************** //
    #[Route('/test/sale/crear', name: 'sale_crear')]
    public function crearTienda(ManagerRegistry $doctrine,Request $request): Response
    {
        
        // Creacion formulario
        $form = $this->createFormBuilder()
            ->add('nombre')
            ->add('Crear',SubmitType::class)
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
                $entityManager = $doctrine->getManager();
                $data = $form->getData();
                $sale = new Sale($data['nombre']);
                $entityManager->persist($sale);
                $entityManager->flush();
                return $this->redirectToRoute('app_test',);
        }
        return $this->render('/test/sale/saleCrear.html.twig',array('form'=>$form->createView()));
    }

    // ******************************* Metodo para eliminar clientes ***************************** //
    #[Route('/test/sale/eliminar', name: 'sale_borrar')]
    public function eliminarTienda(ManagerRegistry $doctrine,Request $request): Response
    {
        
        // Creacion formulario
        $form = $this->createFormBuilder()
            ->add('idTienda')
            ->add('Eliminar',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

                $entityManager = $doctrine->getManager();
                $data = $form->getData();
                $sale =  $entityManager->getRepository(Sale::class)->find($data['idTienda']);
                $entityManager->remove($sale);
                $entityManager->flush();
                return $this->redirectToRoute('app_test',);
        }

        return $this->render('/test/sale/saleEliminar.html.twig',array('form'=>$form->createView()));
    }

    // ******************************* Metodo para actualizar clientes ***************************** //
    #[Route('/test/sale/actualizar', name: 'sale_actualizar')]
    public function actualizarTienda(ManagerRegistry $doctrine,Request $request): Response
    {
        // Creacion formulario
        $form = $this->createFormBuilder()
            ->add('idTienda')
            ->add('nombre')
            ->add('Actualizar',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

                $entityManager = $doctrine->getManager();
                $data = $form->getData();
                $sale = $entityManager->getRepository(Sale::class)->find($data['idTienda']);
                $sale->setNombreTienda($data['nombre']);
                $entityManager->flush();
                return $this->redirectToRoute('app_test',);
        }

        return $this->render('/test/sale/saleActualizar.html.twig',array('form'=>$form->createView()));
    }

    // =====================================================================================
    // ============================== END CRUD SALE ===================================
    // =====================================================================================

    // =====================================================================================
    // ============================== BUY PRODUCTS =========================================
    // =====================================================================================

    #[Route('/comprar', name: 'buy')]
    public function realizarCompra(ManagerRegistry $doctrine,Request $request): Response
    {
        // Creacion formulario
        $form = $this->createFormBuilder()
            ->add('Cliente',EntityType::class,[
                    'class' =>Customer::class,
                    'choice_label' => function ($idCliente) {
                    return $idCliente->getNombres();
                }
            ])
            ->add('Producto',EntityType::class,[
                    'class' =>Product::class,
                    'choice_label' => function ($idProducto) {
                    return $idProducto->getNombre();
                }
            ])
            ->add('Tienda',EntityType::class,[
                    'class' =>Sale::class,
                    'choice_label' => function ($idTienda) {
                    return $idTienda->getNombreTienda();
                }
            ])
            ->add('Cantidad')
            ->add('Valor')
            ->add('FechaCompra')
            ->add('Comprar',SubmitType::class)
            ->getForm();

            // $customer = new Customer($data['documento'],$data['nombres']);
            // $customer->setSale($data['sale']);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
                $entityManager = $doctrine->getManager();
                $data = $form->getData();
                $compra = new Compra($data['Cantidad'],$data['Valor'],$data['FechaCompra']);
                $compra->setIdCompra($data['Tienda']);
                $compra->setIdCustomer($data['Cliente']);
                $compra->setIdProduct($data['Producto']);
                $entityManager->persist($compra);
                $entityManager->flush();
                return $this->redirectToRoute('app_test',);
        }
        return $this->render('/test/realizarCompra.html.twig',array('form'=>$form->createView()));
    }
}


