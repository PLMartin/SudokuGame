<?php

namespace App\DataFixtures;

use App\Entity\Sudoku;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SavedSudokuFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $sudoku = new Sudoku();
        $sudoku->initializeGame(3);
        $manager->persist($sudoku);
        $manager->flush();
    }
}
