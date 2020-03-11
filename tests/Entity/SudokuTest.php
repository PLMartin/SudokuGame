<?php


namespace Tests\Entity;

use App\Entity\Sudoku;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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



    public function wrongPositionProvider()
    {
        yield [-1, 0];
        yield [0, -1];
        yield [9, 0];
        yield [0, 9];
    }

    /**
     * @param $x
     * @param $y
     * @dataProvider wrongPositionProvider
     * @expectedException \LogicException
     */
    public function testPlayWrongPosition($x, $y)
    {
        $sudoku = new Sudoku();
        $sudoku->play($x, $y, 1);
    }


    /**
     * @expectedException \LogicException
     */
    public function testPlayTwiceOnTheSameCell()
    {
        $sudoku = new Sudoku();
        $sudoku->play(0, 0, 1);
        $sudoku->play(0, 0, 1);
    }


    public function wrongValueProvider()
    {
        yield [-1];
        yield [0];
        yield [10];
    }


    /**
     * @dataProvider wrongValueProvider
     * @expectedException \LogicException
     * @param $value
     */
    public function testPlayWrongValue($value)
    {
        $sudoku = new Sudoku();
        $sudoku->play(0, 0, $value);
    }



    public function testVerifyCellAlreadyInLine()
    {
        $sudoku = new Sudoku();
        $sudoku->play(1, 1, 1);
        $this->assertFalse($sudoku->verifyCell(8, 1, 1));
    }

    public function testVerifyCellAlreadyInColumn()
    {
        $sudoku = new Sudoku();
        $sudoku->play(1, 1, 1);
        $this->assertFalse($sudoku->verifyCell(1, 8, 1));
    }

    public function testVerifyCellAlreadyInBlock()
    {
        $sudoku = new Sudoku();
        $sudoku->play(0, 0, 1);
        $this->assertFalse($sudoku->verifyCell(2, 2, 1));

        $sudoku->play(8, 8, 1);
        $this->assertFalse($sudoku->verifyCell(7, 7, 1));
    }









}