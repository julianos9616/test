<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    //================================== CONSULTAS SQL===============================

    //Clasificación de los primeros 5 clientes con más compras en el mes
    public function clasificacionCincoPrimerosClientes(){
        return $this->getEntityManager()->createQuery('
        SELECT customer.nombres, (compra.valor * compra.cantidad_producto_comprado) AS total FROM customer INNER JOIN compra ON customer.id = compra.id_customer_id ORDER BY total DESC LIMIT 5;')
        ->getResult();
    }

    //Clasificación de los primeros 5 productos mas vendidos en el mes
    public function clasificacionCincoPrimerosProductos(){
        return $this->getEntityManager()->createQuery('
        SELECT product.nombre, (compra.valor * compra.cantidad_producto_comprado) AS total FROM product INNER JOIN compra ON product.id = compra.id_product_id ORDER BY total DESC LIMIT 5;')
        ->getResult();
    }


    // Mostrar el valor total por producto y por cliente comprados en un rango de fechas
    public function buscarClientesConMasVentas(){
        return $this->getEntityManager()->createQuery('
        SELECT customer.nombres, product.nombre as NombreProducto,product.precio * product.cantidad as totalComprado 
        FROM product INNER JOIN customer ON product.customer_id = customer.id;')
        ->getResult();
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
