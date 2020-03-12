<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SudokuRepository")
 */
class Sudoku
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $data;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberOfEmptyCells;

    /**
     * @ORM\Column(type="integer")
     */
    private $difficulty;

    /**
     * @ORM\Column(type="time")
     */
    private $time;


    public function __construct()
    {
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $this->data[$i][$j] = null;
            }
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): ?array
    {
        return $this->data;
    }


    public function getNumberOfEmptyCells(): ?int
    {
        return $this->numberOfEmptyCells;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;
        return $this;
    }


    /**
     * @param int $difficulty
     * @throws \Exception
     */
    public function initializeGame(int $difficulty): void
    {

        switch ($difficulty) {
            case 1:
                $this->numberOfEmptyCells = 81 - 40;
                $this->generateGame(40);
                break;
            case 2:
                $this->numberOfEmptyCells = 81 - 30;
                $this->generateGame(30);
                break;
            case 3:
                $this->numberOfEmptyCells = 81 - 20;
                $this->generateGame(20);
                break;
            default:
                throw new \Exception("La difficulté est invalide.");
        }
        $this->difficulty = $difficulty;
        $this->time = new \DateTime('00:00:00');

    }


    private function generateGame(int $numberOfFilledCells)
    {
        $x = [];
        $y = [];
        $values = [];

        for ($i = 1; $i < 10; $i++) {
            array_push($values, $i);
            array_push($y, $i - 1);
            array_push($x, $i - 1);
        }

        while ($numberOfFilledCells > 0) {

            shuffle($values);
            shuffle($x);
            shuffle($y);
            foreach ($values as $key => $value) {
                if ($this->verifyCell($x[$key], $y[$key], $value)) {
                    $this->data[$x[$key]][$y[$key]] = $value;
                    $numberOfFilledCells -= 1;
                    if ($numberOfFilledCells <= 0) {
                        break;
                    }
                }
            }
        }
    }


    public function play(int $x, int $y, int $value): void
    {

        if ($value < 1 || $value > 9) {
            throw new \LogicException("La valeur entrée doit etre comprise entre 1 et 9 : ${value}");
        }

        if ($x > 8 || $x < 0 || $y > 8 || $y < 0) {
            throw new \LogicException("Impossible de jouer en (${x} ${y}), coordonnées incorrects.");
        }

        if ($this->data[$x][$y] !== null) {
            throw new \LogicException("Impossible de jouer, la cellule (${x} ${y}) n'est pas vide.");
        }

        $this->data[$x][$y] = $value;
    }


    public function verifyCell(int $x, int $y, int $value): bool
    {
        return $this->data[$x][$y] === null &&
            $this->verifyBlock($x, $y, $value) &&
            $this->verifyColumn($x, $y, $value) &&
            $this->verifyLine($x, $y, $value);
    }

    private function verifyBlock(int $x, int $y, int $value)
    {
        for ($i = intdiv($x, 3) * 3; $i < intdiv($x, 3) * 3 + 3; $i++) {
            for ($j = intdiv($y, 3) * 3; $j < intdiv($y, 3) * 3 + 3; $j++) {
                if ($i === $x && $j === $y) {
                    continue;
                }
                if ($this->data[$i][$j] === $value) {
                    return false;
                }
            }
        }
        return true;
    }


    private function verifyLine(int $x, int $y, int $value): bool
    {
        for ($i = 0; $i < 9; $i++) {
            if ($i === $x) {
                continue;
            }
            if ($this->data[$i][$y] === $value) {
                return false;
            }
        }
        return true;

    }

    private function verifyColumn(int $x, int $y, int $value)
    {
        for ($j = 0; $j < 9; $j++) {
            if ($j === $y) {
                continue;
            }
            if ($this->data[$x][$j] === $value) {
                return false;
            }
        }
        return true;

    }

    public function serializeData()
    {
        $this->data = json_encode($this->data);
    }

    public function deserializeData()
    {
        $this->data = json_decode($this->data);
    }

}
