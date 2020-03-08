<?php


namespace Tests\Entity;

use App\Entity\Sudoku;
use PHPUnit\Framework\TestCase;

class SudokuTest extends TestCase
{

    public function difficultyProvider()
    {
        yield [1, 50];
        yield [2, 40];
        yield [3, 30];
    }

    /**
     * @param $difficulty
     * @param $numberOfFilledCells
     * @dataProvider difficultyProvider
     */
    public function testNumberOfFilledCellsAfterInitializing($difficulty, $numberOfFilledCells)
    {
        $sudoku = new Sudoku();
        $sudoku->initializeGame($difficulty);
        $this->assertEquals(81 - $numberOfFilledCells, $sudoku->getNumberOfEmptyCells());

        $count = 0;
        foreach($sudoku->getData() as $lines) {
            foreach ($lines as $cell) {
                if ($cell > 0 && $cell < 10) {
                    $count += 1;
                }
            }
        }

        $this->assertEquals(81 - $numberOfFilledCells, $count);
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
    public function testInvalidDifficulty($difficulty)
    {
        $sudoku = new Sudoku();
        $sudoku->initializeGame($difficulty);
    }

}