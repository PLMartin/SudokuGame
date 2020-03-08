<?php


namespace Tests\Entity;

use App\Entity\Sudoku;
use PHPUnit\Framework\TestCase;

class SudokuTest extends TestCase
{

    public function difficultyProvider()
    {
        yield ['level' => 1, 'filledCells' => 50];
        yield ['level' => 2, 'filledCells' => 40];
        yield ['level' => 3, 'filledCells' => 30];
    }

    /**
     * @param $difficulty
     * @dataProvider difficultyProvider
     */
    public function testNumberOfFilledCellsAfterInitializing(array $difficulty)
    {
        $sudoku = new Sudoku();
        $sudoku->initializeGame($difficulty['level']);
        $this->assertEquals($difficulty['filledCells'], $sudoku->getNumberOfEmptyCells());

        $numberOfFilledCells = 0;
        foreach($sudoku->getData() as $lines) {
            foreach ($lines as $cell) {
                if ($cell > 0 && $cell < 10) {
                    $numberOfFilledCells += 1;
                }
            }
        }

        $this->assertEquals($difficulty['filledCells'], $numberOfFilledCells);
    }

}