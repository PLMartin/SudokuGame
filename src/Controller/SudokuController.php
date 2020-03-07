<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SudokuController extends AbstractController
{
    /**
     * @Route("/sudoku", name="sudoku")
     */
    public function index()
    {
        return $this->render('sudoku/index.html.twig', [
            'controller_name' => 'SudokuController',
        ]);
    }
}
