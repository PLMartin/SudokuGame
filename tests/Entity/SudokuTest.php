<?php


namespace Tests\Entity;

use App\Entity\Sudoku;
use PHPUnit\Framework\TestCase;

class SudokuTest extends TestCase
{

    public function validDifficultyProvider()
    {
        yield [1, 50];
        yield [2, 40];
        yield [3, 30];
    }

    /**
     * @param $difficulty
     * @param $numberOfFilledCells
     * @dataProvider validDifficultyProvider
     * @throws \Exception
     */
    public function testInitializeWithValidDifficulty($difficulty, $numberOfFilledCells)
    {
        $sudoku = new Sudoku();
        $sudoku->initializeGame($difficulty);
        $errorMessage = "Le nombre de cellules vides est incorrect pour la difficulté: ${difficulty}";
        $this->assertEquals(81 - $numberOfFilledCells, $sudoku->getNumberOfEmptyCells(), $errorMessage);
        $errorMessage = "La difficulté n'a pas été enregistré dans l'instance";
        $this->assertEquals($difficulty, $sudoku->getDifficulty(), $errorMessage);

        $count = 0;
        foreach($sudoku->getData() as $lines) {
            foreach ($lines as $cell) {
                if ($cell > 0 && $cell < 10) {
                    $count += 1;
                }
            }
        }

        $errorMessage = "Le nombre de cellules vides générées est incorrect pour la difficulté: ${difficulty}";
        $this->assertEquals($numberOfFilledCells, $count, $errorMessage);
    }





    public function wrongDifficultyProvider()
    {
        yield [0];
        yield [4];
        yield [-1];
    }


    /**
     * @expectedException \Exception
     * @dataProvider wrongDifficultyProvider
     * @param $difficulty
     */
    public function testInitializeWithInvalidDifficulty($difficulty)
    {
        $sudoku = new Sudoku();
        $sudoku->initializeGame($difficulty);
    }

}