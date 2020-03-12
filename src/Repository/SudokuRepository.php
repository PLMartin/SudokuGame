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

    public function init(Sudoku $sudoku): void
    {
        $this->deleteAll();
        $this->save($sudoku);
    }


    public function save(Sudoku $sudoku): void
    {
        $sudoku->serializeData();
        $this->_em->persist($sudoku);
        $this->_em->flush();
    }

    private function deleteAll(): void
    {
        $qb = $this->_em->createQueryBuilder();
        $query = $qb->delete()
            ->from(Sudoku::class, 's')
            ->getQuery();

        $query->execute();
    }




}
