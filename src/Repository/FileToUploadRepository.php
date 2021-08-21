<?php

namespace App\Repository;

use App\Entity\FileToUpload;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FileToUpload|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileToUpload|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileToUpload[]    findAll()
 * @method FileToUpload[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileToUploadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileToUpload::class);
    }

    // /**
    //  * @return FileToUpload[] Returns an array of FileToUpload objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FileToUpload
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
