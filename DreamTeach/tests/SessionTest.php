<?php
/**
 * Created by PhpStorm.
 * User: Adel
 * Date: 17/04/2019
 * Time: 14:33
 */

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SessionTest extends WebTestCase
{
    public function testValidConnexion($userEmail = 'adel.mekki1998@hotmail.com', $userPassword = 'adelmekki')
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

    function testClickCreateSession ()
    {
        $client = $this->testValidConnexion();
        $crawler = $client->request('GET', '/dashboard');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $linkRegister = $crawler
            ->filter('a:contains("Créer une séance")') // find all links with the text "S'inscrire"
            ->eq(0) // selectionne le 1er lien trouvé
            ->link()
        ;
        // Vérifie que la redirection n'a pas encore été effectuée
        $this->assertNotEquals('http://localhost/nouvellesession', $crawler->getUri());
        $crawler = $client->click($linkRegister);
        $this->assertEquals('http://localhost/nouvellesession', $crawler->getUri());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Description séance")')->count()
        );
    }

    function testSessionDisplayPage ()
    {
        $client = $this->testValidConnexion();
        $crawler = $client->request('GET', '/showSessions');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Séances")')->count()
        );
    }
}