<?php

namespace App\Repository;

use App\Entity\ConfigurationPayfip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConfigurationPayfip>
 *
 * @method ConfigurationPayfip|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfigurationPayfip|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfigurationPayfip[]    findAll()
 * @method ConfigurationPayfip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfigurationPayfipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfigurationPayfip::class);
    }


    public function save(ConfigurationPayfip $configurationPayfip, bool $flush = false): void
    {
        $this->getEntityManager()->persist($configurationPayfip);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConfigurationPayfip $configurationPayfip, bool $flush = false): void
    {
        $this->getEntityManager()->remove($configurationPayfip);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


//    /**
//     * @return ConfigurationPayfip[] Returns an array of ConfigurationPayfip objects
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

//    public function findOneBySomeField($value): ?ConfigurationPayfip
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
