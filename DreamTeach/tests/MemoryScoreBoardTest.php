<?php
/**
 * Created by PhpStorm.
 * User: Adel
 * Date: 18/04/2019
 * Time: 10:51
 */

namespace App\Tests;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class MemoryScoreBoardTest extends WebTestCase
{
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

    function connexionLoginPage ($client, $username, $password)
    {
        // Remplissage du formulaire avec identifiants valides sur la page de login
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Connexion')->form();

        $form['emailaddress'] = $username;
        $form['password'] =  $password;
        return $client->submit($form);
        // On vérifie que la page ne contient pas le message de bienvenue (connexion invalide)
    }

    function testDisplayMemoryScoreBoard ()
    {
        $client = $this->testValidConnexion();
        $crawler = $client->request('GET', '/tableauScore/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Classement")', 'html:contains("Aucun résultat trouvé")')->count()
        );
    }
}