<?php


namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;



class SudokuControllerTest extends WebTestCase
{

    public function testNewGame()
    {
        $client = static::createClient();
        $client->request('GET', '/new-game');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testHome()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }



    public function testPlay()
    {
        $client = static::createClient();
        $client->request('GET', '/play');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
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
    public function testRedirectionAfterGenerateSudokuWithGoodDifficulty($difficulty)
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



}