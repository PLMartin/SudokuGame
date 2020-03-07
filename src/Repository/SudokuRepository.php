<?php

namespace App\Repository;

use App\Entity\Sudoku;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Sudoku|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sudoku|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sudoku[]    findAll()
 * @method Sudoku[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SudokuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sudoku::class);
    }

    // /**
    //  * @return Sudoku[] Returns an array of Sudoku objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sudoku
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
