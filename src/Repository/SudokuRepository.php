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

    public function save(Sudoku $sudoku) {
        $sudoku->serializeData();
        $this->_em->persist($sudoku);
        $this->_em->flush();
    }




}
