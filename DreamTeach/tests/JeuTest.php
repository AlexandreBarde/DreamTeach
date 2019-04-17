<?php

use PHPUnit\Framework\TestCase;
use App\tests\HomepageTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 22/03/19
 * Time: 16:12
 */
class JeuTest extends WebTestCase
{

    function connexionLoginPage($client, $username, $password)
    {
        // Remplissage du formulaire avec identifiants valides sur la page de login
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Connexion')->form();

        $form['emailaddress'] = $username;
        $form['password'] = $password;
        return $client->submit($form);
        // On vérifie que la page ne contient pas le message de bienvenue (connexion invalide)
    }

    public function testValidConnexion($userEmail = 'test@mail.com', $userPassword = 'test12345678')
    {
        $client = static::createClient();

        // Vérifie que la page "/dashboard" n'est pas accessible et renvoie bien un code 302 (redirection) lorsqu'on est pas connecté
        $client->request('GET', '/dashboard');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        // Connexion avec les identifiants passés en paramètres de la fonction (identifiants valides et à modifier selon le pc
        $crawler = $this->connexionLoginPage($client, $userEmail, $userPassword);

        // On vérifie que sur la rou te "/" (requête effectuée par la fonction connexionLoginPage) on a pas le message de bienvenue
        $this->assertLessThan(
            1,
            $crawler->filter('html:contains("Bienvenue sur votre espace personnel")')->count()
        );

        // Vérifie que la page "/dashboard" est accessible et renvoie bien un code 200 lorsqu'on est connecté ainsi que le message de bienvenue
        $crawler = $client->request('GET', '/dashboard');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Bienvenue sur votre espace personnel")')->count()
        );
        return $client;
    }

    public function testRouteHangman()
    {
        $client = $this->testValidConnexion();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/hangman');
        $this->assertEquals('http://localhost/hangman', $crawler->getUri());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Jeu du pendu")')->count()
        );
    }

    public function testhangmanCheat()
    {
        $client = $this->testValidConnexion();
        $crawler = $client->request('GET', '/hangmanWinner');
        $this->assertEquals('http://localhost/hangmanWinner', $crawler->getUri());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Hmmm, c\'est pas normal ça !")')->count()
        );
    }

    public function testMemoryRoute()
    {
        $client = $this->testValidConnexion();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', 'games/memory');
        $this->assertEquals('http://localhost/games/memory', $crawler->getUri());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Memory")')->count()
        );
    }

    public function testRelancerMemory()
    {
        $client = $this->testValidConnexion();
        $crawler = $client->request('GET', 'games/memory');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());



    }


}