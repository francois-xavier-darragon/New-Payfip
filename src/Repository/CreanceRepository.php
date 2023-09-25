<?php

namespace App\Repository;

use App\Entity\Creance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Creance>
 *
 * @method Creance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Creance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Creance[]    findAll()
 * @method Creance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creance::class);
    }

    public function save(Creance $creance, bool $flush = false): void
    {
        $this->getEntityManager()->persist($creance);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Creance $creance, bool $flush = false): void
    {
        $this->getEntityManager()->remove($creance);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function dernierPaiment()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.dattrans',  'DESC')
            ->addOrderBy('c.heurTrans','DESC')
            ->where('c.statut = 1')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Creance[] Returns an array of Creance objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Creance
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
