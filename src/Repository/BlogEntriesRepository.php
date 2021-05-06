<?php

namespace App\Repository;

use App\Entity\BlogEntries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogEntries|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogEntries|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogEntries[]    findAll()
 * @method BlogEntries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogEntriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogEntries::class);
    }

    public function buscarEntradasBlog($result=false)
    {
        $Query = $this->getEntityManager()->createQuery(
            'SELECT post.id, post.title, post.text, post.image, post.date
            FROM App:BlogEntries post'
        );
        return $result ? $Query->getResult() : $Query;
    }

    // /**
    //  * @return BlogEntries[] Returns an array of BlogEntries objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BlogEntries
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
