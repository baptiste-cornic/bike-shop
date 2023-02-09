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

    public function save(Product $entity, bool $flush = false): void
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

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function SearchProduct($word, $minPrice, $maxPrice, $brand): array
    {
        $dql = $this->createQueryBuilder('p')
            ->andWhere('p.isValid = true')
            ->orderBy('p.productType', 'ASC');

        if ($word){
            $dql->andWhere('p.name LIKE :word OR p.brand LIKE :word')
                ->setParameter('word', '%'.$word.'%');
        }

        if ($minPrice){
            $dql->andWhere('p.price >= :minPrice')
                ->setParameter('minPrice', $minPrice);
        }

        if ($maxPrice){
            $dql->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $maxPrice);
        }

        if ($brand){
            $dql->andWhere('p.brand LIKE :brand')
                ->setParameter('brand', $brand);
        }

        return $dql->getQuery()->execute();
    }

    public function getProductBrand(){
        return $this->createQueryBuilder('p')
            ->select('p.brand')
            ->groupBy("p.brand")
            ->andWhere('p.isValid = true')
            ->getQuery()
            ->getResult();
    }

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
