<?php

namespace App\Repository;

use App\Entity\ExtendedFieldOccurrence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExtendedFieldOccurrence>
 *
 * @method ExtendedFieldOccurrence|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExtendedFieldOccurrence|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExtendedFieldOccurrence[]    findAll()
 * @method ExtendedFieldOccurrence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExtendedFieldOccurrenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExtendedFieldOccurrence::class);
    }

    public function save(ExtendedFieldOccurrence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ExtendedFieldOccurrence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ExtendedFieldOccurrence[] Returns an array of ExtendedFieldOccurrence objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExtendedFieldOccurrence
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
