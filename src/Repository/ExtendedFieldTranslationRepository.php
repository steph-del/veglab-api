<?php

namespace App\Repository;

use App\Entity\ExtendedFieldTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExtendedFieldTranslation>
 *
 * @method ExtendedFieldTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExtendedFieldTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExtendedFieldTranslation[]    findAll()
 * @method ExtendedFieldTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExtendedFieldTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExtendedFieldTranslation::class);
    }

    public function save(ExtendedFieldTranslation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ExtendedFieldTranslation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ExtendedFieldTranslation[] Returns an array of ExtendedFieldTranslation objects
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

//    public function findOneBySomeField($value): ?ExtendedFieldTranslation
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
