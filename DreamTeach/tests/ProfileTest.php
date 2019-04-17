<?php
/**
 * Created by PhpStorm.
 * User: Adel
 * Date: 17/04/2019
 * Time: 14:22
 */

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileTest extends WebTestCase
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

    function testUpdateProfile ()
    {
        $newFirstName = "georges";
        $newLastName = "georgette";
        $biography = "Aime le tennis de table et les loukoums";

        $client = $this->testValidConnexion();
        $crawler = $client->request('GET', '/mon-profil/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton("Modifier")->form();
        $crawler = $client->click($form);
        $form = $crawler->selectButton("Enregistrer")->form();

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Modifiez vos informations personnelles")')->count()
        );

        $form['profile_form[firstName]'] = $newFirstName;
        $form['profile_form[lastName]'] = $newLastName;
        $form['profile_form[biography]'] = $biography;
        $form['profile_form[birthDate]'] = "1998-04-15";

        $client->submit($form);
        $crawler = $client->request('GET', '/mon-profil/');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains('."$newLastName $newFirstName".')')->count()
        );
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains('."$biography".')')->count()
        );
    }

    function testContentMonProfil ()
    {
        $client = $this->testValidConnexion();
        $crawler = $client->request('GET', '/dashboard');
        $linkRegister = $crawler
            ->filter('a:contains("Mon profil")') // find all links with the text "S'inscrire"
            ->eq(0) // selectionne le 1er lien trouvé
            ->link()
        ;
        // Vérifie que la redirection n'a pas encore été effectuée
        $this->assertNotEquals('http://localhost/mon-profil/', $crawler->getUri());
        $crawler = $client->click($linkRegister);
        $this->assertEquals('http://localhost/mon-profil/', $crawler->getUri());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Badges")')->count()
        );
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Compétences")')->count()
        );
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("georgette georges")')->count()
        );
    }
}