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
    private $data = [];

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
        $this->difficulty = $difficulty;
        switch ($difficulty) {
            case 1:
                $this->numberOfEmptyCells = 81 - 50;
                $this->generateGame(50);
                break;
            case 2:
                $this->numberOfEmptyCells = 81 - 40;
                $this->generateGame(40);
                break;
            case 3:
                $this->numberOfEmptyCells = 81 - 30;
                $this->generateGame(30);
                break;
            default:
                throw new \Exception("La difficulté est invalide.");
        }

    }


    private function generateGame(int $numberOfFilledCells)
    {
        $table = [];
        for ($i = 1; $i < 10; $i++) {
            array_push($table, $i);
        }

        for ($i = 0; $i < 9; $i++) {
            shuffle($table);
            for ($j = 0; $j < 9; $j++) {
                $this->data[$i][$j] = $table[$j];
                $numberOfFilledCells -= 1;
                if ($numberOfFilledCells === 0) {
                    break;
                }
            }
            if ($numberOfFilledCells === 0) {
                break;
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





}
