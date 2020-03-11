<?php

namespace App\Controller;

use App\Entity\Sudoku;
use App\Repository\SudokuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SudokuController extends AbstractController
{


    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('sudoku/index.html.twig', [
            'controller_name' => 'SudokuController',
        ]);
    }

    /**
     * @Route("/play", name="play")
     */
    public function play()
    {
        return $this->render('sudoku/game.html.twig', [
            'controller_name' => 'SudokuController',
        ]);
    }

    /**
     * @Route("/new-game", name="new_game")
     */
    public function newGame()
    {
        return $this->render('sudoku/new-game.html.twig', [
            'controller_name' => 'SudokuController',
        ]);
    }


    /**
     * @Route("/generate", name="generate")
     * @param Request $request
     * @param SudokuRepository $sudokuRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function generate(Request $request, SudokuRepository $sudokuRepository)
    {
        $sudoku = new Sudoku();
        if (!$request->query->has("difficulty")) {
            throw new \Exception("Aucune difficulté renseigné en paramètre");
        }
        $sudoku->initializeGame($request->query->get("difficulty"));
        $sudokuRepository->save($sudoku);

        return $this->redirectToRoute('play');


    }
}
