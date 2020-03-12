<?php

namespace App\Controller;

use App\Entity\Sudoku;
use App\Repository\SudokuRepository;
use PHPUnit\Runner\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SudokuController extends AbstractController
{

    /**
     * @var Sudoku $sudoku
     */
    private $sudoku;

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
     * @param SudokuRepository $sudokuRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function play(SudokuRepository $sudokuRepository)
    {
        $this->sudoku = $sudokuRepository->findAll()[0];
        $this->sudoku->deserializeData();

        return $this->render('sudoku/game.html.twig', [
            'controller_name' => 'SudokuController',
            'sudoku' => $this->sudoku
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
        $this->sudoku = new Sudoku();
        if (!$request->query->has("difficulty")) {
            throw new \Exception("Aucune difficulté renseigné en paramètre.");
        }

        $this->sudoku->initializeGame($request->query->get("difficulty"));
        $sudokuRepository->init($this->sudoku);

        return $this->redirectToRoute('play');

    }


    /**
     * @Route("/select-value", name="select_value")
     * @param Request $request
     * @return Response
     */
    public function selectValue(Request $request)
    {
        $view = $this->renderView("sudoku/select-value.html.twig", [
            'x' => $request->query->get('x'),
            'y' => $request->query->get('y')
        ]);

        return new Response($view, 200);
    }

    /**
     * @Route("/enter-value", name="enter_value")
     * @param Request $request
     * @param SudokuRepository $sudokuRepository
     * @return Response
     * @throws \Exception
     */
    public function enterValue(Request $request, SudokuRepository $sudokuRepository)
    {
        $x = $request->query->get('x');
        $y = $request->query->get('y');
        $value = $request->query->get('value');

        $this->sudoku = $sudokuRepository->findAll()[0];
        $this->sudoku->deserializeData();

        if ($this->sudoku === null) {
            throw new \Exception("Vous ne pouvez jouez alors que la grille n'a pas encore été générée.");
        }

        $canPlay = $this->sudoku->verifyCell($x, $y, $value);
        if ($canPlay) {
            $this->sudoku->play($x, $y, $value);
            $sudokuRepository->save($this->sudoku);
            return $this->redirectToRoute('valid_entry');
        }


        return $this->redirectToRoute('wrong_entry');
    }


    /**
     * @Route("/valid-entry", name="valid_entry")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function validEntry(Request $request)
    {
        return $this->render("sudoku/valid-entry.html.twig");
    }


    /**
     * @Route("/wrong-entry", name="wrong_entry")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function wrongEntry(Request $request)
    {
        return $this->render("sudoku/wrong-entry.html.twig");
    }

}
