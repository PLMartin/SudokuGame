<?php

namespace App\Entity;

use App\ValueObject\Difficuly;
use Doctrine\DBAL\Types\TimeType;
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

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getNumberOfEmptyCells(): ?int
    {
        return $this->numberOfEmptyCells;
    }

    public function setNumberOfEmptyCells(int $numberOfEmptyCells): self
    {
        $this->numberOfEmptyCells = $numberOfEmptyCells;

        return $this;
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


    public function initializeGame(int $difficulty): void
    {


    }



}
