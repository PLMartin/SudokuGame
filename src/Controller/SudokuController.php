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
     * @var SudokuRepository $sudokuRepository
     */
    private $sudokuRepository;


    public function __construct(SudokuRepository $sudokuRepository)
    {
        $this->sudokuRepository = $sudokuRepository;

        $data = $this->sudokuRepository->findAll();
        $this->sudoku = empty($data) ? null : $data[0];
        if ($this->sudoku !== null) {

            $this->sudoku->deserializeData();
        }

    }


    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        if ($this->sudoku === null) {
            return $this->redirect($this->generateUrl('new_game'));
        }
        return $this->render('sudoku/index.html.twig', [
            'controller_name' => 'SudokuController',
        ]);
    }

    /**
     * @Route("/play", name="play")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function play()
    {
        if ($this->sudoku === null || empty($this->sudoku->getData())) {
            throw new \LogicException("Impossible de jouer, la grille n'a pas encore été générée.");
        }

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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function generate(Request $request)
    {
        if (!$request->query->has("difficulty")) {
            throw new \Exception("Aucune difficulté renseigné en paramètre.");
        }
        $this->sudoku = new Sudoku();
        $this->sudoku->initializeGame($request->query->get("difficulty"));
        $this->sudokuRepository->init($this->sudoku);

        return $this->redirectToRoute('play');
    }


    /**
     * @Route("/select-value", name="select_value")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function selectValue(Request $request)
    {
        if (!($request->query->has('x') && $request->query->has('y'))) {
            throw new \Exception("Le paramètre x, y ou value est manquant.");
        }

        $view = $this->renderView("sudoku/select-value.html.twig", [
            'x' => $request->query->get('x'),
            'y' => $request->query->get('y')
        ]);

        return new Response($view, 200);
    }


    /**
     * @Route("/enter-value", name="enter_value")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function enterValue(Request $request)
    {

        if (!($request->query->has('x') && $request->query->has('y') && $request->query->has('value'))) {
            throw new \Exception("Le paramètre x, y ou value est manquant.");
        }

        $x = $request->query->get('x');
        $y = $request->query->get('y');
        $value = $request->query->get('value');

        if ($this->sudoku === null) {
            throw new \Exception("Vous ne pouvez jouez alors que la grille n'a pas encore été générée.");
        }

        $canPlay = $this->sudoku->verifyCell($x, $y, $value);
        if ($canPlay) {
            $this->sudoku->play($x, $y, $value);
            $this->sudokuRepository->save($this->sudoku);
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
