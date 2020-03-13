<?php


namespace Tests\Controller;

use App\Controller\SudokuController;
use App\DataFixtures\SavedSudokuFixtures;
use App\Repository\SudokuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;



class SudokuControllerTest extends WebTestCase
{

    private $sudokuController;


    protected function setUp(): void
    {
        $sudokuRepository = $this->createPartialMock(SudokuRepository::class, ['findAll', 'init', 'save']);

        $sudokuRepository->expects($this->any())
            ->method('init')
            ->willReturn(null);

        $sudokuRepository->expects($this->any())
            ->method('save')
            ->willReturn(null);

        $sudokuRepository->expects($this->any())
            ->method('findAll')
            ->willReturn([]);

        $this->sudokuController = new SudokuController($sudokuRepository);
    }

    public function testNewGame()
    {

        $client = static::createClient();
        $client->request('GET', '/new-game');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testHomeWithGameSaved()
    {
//        $fixture = new SavedSudokuFixtures();

        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testHomeWithoutGameSaved()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isRedirect('/new-game'),
            "L'utilisateur doit etre redirigé automatiquement depuis l'accueil vers la page de création de partie s'il n'y a aucune sauvegarde.");
    }



    public function testPlayWithoutSudokuGenerated()
    {
        $client = static::createClient();
        $client->request('GET', '/play');
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }


    public function testGenerateWithoutDifficulty()
    {
        $client = static::createClient();
        $client->request('GET', '/generate');
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }


    public function validDifficultyProvider()
    {
        yield [1];
        yield [2];
        yield [3];
    }

    /**
     * @dataProvider validDifficultyProvider
     * @param $difficulty
     */
    public function testRedirectionAfterGenerateSudokuWithValidDifficulty($difficulty)
    {
        $client = static::createClient();

        $client->request('GET', '/generate', ['difficulty' => $difficulty]);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }


    public function invalidDifficultyProvider()
    {
        yield [-1];
        yield [4];
        yield [999];
    }

    /**
     * @dataProvider invalidDifficultyProvider
     * @param $difficulty
     */
    public function testAfterGenerateSudokuWithInvalidDifficulty($difficulty)
    {
        $client = static::createClient();
        $client->request('GET', '/generate', ['difficulty' => $difficulty]);
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }



    public function testEnterValueWithoutPosition()
    {
        $client = static::createClient();
        $client->request('GET', '/enter-value', ['value' => 1]);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());

        //$this->assertEquals("Le paramètre x, y ou value est manquant.", $client->getResponse()->getContent());
    }

    public function testEnterValueWithoutValue()
    {
        $client = static::createClient();
        $client->request('GET', '/enter-value', ['x' => 1, 'y' => 1]);
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
        //$this->assertEquals("Le paramètre x, y ou value est manquant.", $client->getResponse()->getContent());
    }


    public function testValidEntry()
    {

        $client = static::createClient();
        $client->request('GET', '/valid-entry');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testWrongEntry()
    {

        $client = static::createClient();
        $client->request('GET', '/wrong-entry');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }



}