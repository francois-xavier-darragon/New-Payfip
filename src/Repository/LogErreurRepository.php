<?php

namespace App\Repository;

use App\Entity\LogErreur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogErreur>
 *
 * @method LogErreur|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogErreur|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogErreur[]    findAll()
 * @method LogErreur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogErreurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogErreur::class);
    }

    public function save(LogErreur $logErreur, bool $flush = false): void
    {
        $this->getEntityManager()->persist($logErreur);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LogErreur $logErreur, bool $flush = false): void
    {
        $this->getEntityManager()->remove($logErreur);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LogErreur[] Returns an array of LogErreur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LogErreur
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
