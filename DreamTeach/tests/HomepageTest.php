<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 22/03/19
 * Time: 16:12
 */

class HomepageTest extends WebTestCase
{

    public function testCodeReturn()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPageFailedConnexion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertLessThan(
            1,
            $crawler->filter('html:contains("L\'adresse email n\'a pas été trouvé !")')->count()
        );

        $form = $crawler->selectButton('Connexion')->form();
        $client->submit($form);

        // Récupération de la page après envoi du formulaire vide
        $crawler = $client->request('GET', '/');

        // Check that after clicking "Connexion" button with wrong informations in form, the page will contain an error message
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("L\'adresse email n\'a pas été trouvé !")')->count()
        );

    }

    public function testValidConnexion($userEmail = 'jean.jacques@outlook.fr', $userPassword = 'jeanjacques')
    {
        $client = static::createClient();

        // Vérifie que la page "/dashboard" n'est pas accessible et renvoie bien un code 302 (redirection) lorsqu'on est pas connectés
        $client->request('GET', '/dashboard');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        // Remplissage du formulaire avec identifiants valides sur la page de login
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Connexion')->form();

        $form['emailaddress'] = $userEmail;
        $form['password'] =  $userPassword;
        $client->submit($form);
        // On vérifie que la page ne contient pas le message de bienvenue (connexion invalide)
        $this->assertLessThan(
            1,
            $crawler->filter('html:contains("Bienvenue sur votre espace personnel")')->count()
        );

        // Vérifie que la page "/dashboard" est accessible et renvoie bien un code 200 lorsqu'on est connecté
        $crawler = $client->request('GET', '/dashboard');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // On vérifie que la page contient bien le message de bienvenue (connexion valide)
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Bienvenue sur votre espace personnel")')->count()
        );
    }

    public function testClickInscriptionButton()
    {
        $client = static::createClient();

        // Vérifie que la page "/dashboard" n'est pas accessible et renvoie bien un code 302 (redirection) lorsqu'on est pas connectés
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $linkRegister = $crawler
            ->filter('a:contains("S\'inscrire")') // find all links with the text "S'inscrire"
            ->eq(0) // select the second link in the list
            ->link()
        ;
        $crawler = $client->click($linkRegister);

        $this->assertEquals('http://localhost/register', $crawler->getUri());

    }

    public function testInscriptionValide()
    {
        $client = static::createClient();

        // Vérifie que la page "/dashboard" n'est pas accessible et renvoie bien un code 302 (redirection) lorsqu'on est pas connectés
        $crawler = $client->request('GET', '/');

        // Click bouton s'inscrire
        $linkRegister = $crawler
            ->filter('a:contains("S\'inscrire")') // find all links with the text "S'inscrire"
            ->eq(0) // select the second link in the list
            ->link()
        ;
        $crawler = $client->click($linkRegister);
        $this->assertEquals('http://localhost/register', $crawler->getUri());

        $userFirstName = 'Jean';
        $userLastName = 'Donacien';
        $userPassword = 'JeanDonacien';
        $userEmail = 'Jean.Donacien@outlook.fr';

        $form = $crawler->selectButton('S\'inscrire')->form();
        $form['register[trainingid]']->select('1');
        $form['register[lastname]'] = $userLastName;
        $form['register[firstname]'] = $userFirstName;
        $form['register[emailaddress]'] = $userEmail;
        $form['register[password]'] = $userPassword;
        $client->submit($form);


        //Connexion avec les identifiants d'inscriptions pour vérifier que l'inscription a bien été faite
        $this->testValidConnexion($userEmail, $userPassword);
    }
}