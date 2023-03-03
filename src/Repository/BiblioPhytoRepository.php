<?php

namespace App\Repository;

use App\Entity\BiblioPhyto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BiblioPhyto>
 *
 * @method BiblioPhyto|null find($id, $lockMode = null, $lockVersion = null)
 * @method BiblioPhyto|null findOneBy(array $criteria, array $orderBy = null)
 * @method BiblioPhyto[]    findAll()
 * @method BiblioPhyto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BiblioPhytoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BiblioPhyto::class);
    }

    public function save(BiblioPhyto $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BiblioPhyto $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return BiblioPhyto[] Returns an array of BiblioPhyto objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BiblioPhyto
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
