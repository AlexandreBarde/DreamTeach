<?php
/**
 * Created by PhpStorm.
 * User: Adel
 * Date: 17/04/2019
 * Time: 14:24
 */

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginPageTest extends WebTestCase
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

    public function testInvalidConnexion()
    {
        // Requete sur "/" et on vérifie qu'il n'y a pas de message d'erreur avant d'avoir cliqué sur "connexion"
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertLessThan(
            1,
            $crawler->filter('html:contains("L\'adresse email n\'a pas été trouvé !")')->count()
        );

        // Click sur le bouton "Connexion"
        $form = $crawler->selectButton('Connexion')->form();
        $client->submit($form);

        // Récupération de la page après envoi du formulaire vide et vérification de la présence du message d'erreur
        $crawler = $client->request('GET', '/');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("L\'adresse email n\'a pas été trouvé !")')->count()
        );
    }

    function testClickForgotPassword ()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $linkForgotPassword = $crawler
            ->filter('a:contains("Mot de passe oublié ?")') // find all links with the text "S'inscrire"
            ->eq(0) // sélectionne le 1er lien trouvé
            ->link()
        ;
        // Vérifie que la redirection n'a pas encore été effectuée
        $this->assertNotEquals('http://localhost/forgotPassword', $crawler->getUri());
        $crawler = $client->click($linkForgotPassword);

        // Vérifie que la redirection a bien été effectuée
        $this->assertEquals('http://localhost/forgotPassword', $crawler->getUri());
        return $crawler;
    }

    public function testClickInscriptionButton()
    {
        $client = static::createClient();

        // Vérifie que la page "/" est accessible et renvoi le bon code de retour
        $crawler = $client->request('GET', '/');

        // Récupération et click sur le lien d'inscription
        $linkRegister = $crawler
            ->filter('a:contains("S\'inscrire")') // find all links with the text "S'inscrire"
            ->eq(0) // selectionne le 1er lien trouvé
            ->link()
        ;

        // Vérifie que la redirection n'a pas encore été effectuée
        $this->assertNotEquals('http://localhost/register', $crawler->getUri());
        $crawler = $client->click($linkRegister);

        // Vérifie que la redirection a bien été effectuée
        $this->assertEquals('http://localhost/register', $crawler->getUri());
        return $crawler;
    }

    public function testInscriptionValide()
    {
        $client = static::createClient();

        $crawler = $this->testClickInscriptionButton();
        $userFirstName = 'Jean';
        $userLastName = 'Donacien';
        $userPassword = 'JeanDonacien';
        $userEmail = 'Jean.Donacien@outlook.fr';

        $form = $crawler->selectButton('S\'inscrire')->form();
        $form['register[trainingid]']->select('3');
        $form['register[lastname]'] = $userLastName;
        $form['register[firstname]'] = $userFirstName;
        $form['register[emailaddress]'] = $userEmail;
        $form['register[password]'] = $userPassword;
        $client->submit($form);

        //Connexion avec les identifiants d'inscriptions pour vérifier que l'inscription a bien été faite
        $this->testValidConnexion($userEmail, $userPassword);
    }
}