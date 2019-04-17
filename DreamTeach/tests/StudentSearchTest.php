<?php
/**
 * Created by PhpStorm.
 * User: Adel
 * Date: 17/04/2019
 * Time: 14:27
 */

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StudentSearchTest extends WebTestCase
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

    // "Adel" est enregistré en base
    function testValidStudentSearch($studentName = 'adel') {
        $client = $this->testValidConnexion();
        $crawler = $client->request('GET', '/dashboard');
        $form = $crawler->selectButton('Rechercher')->form();
        $form['search_student'] = $studentName;
        $crawler = $client->request('GET', '/search?search_student=' . $studentName);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains(' . $studentName . ')')->count()
        );
    }
    // "Antonin" n'est pas enregistré en base
    function testInvalidStudentSearch($studentName = 'Antonin') {
        $client = $this->testValidConnexion();
        $crawler = $client->request('GET', '/dashboard');
        $form = $crawler->selectButton('Rechercher')->form();
        $form['search_student'] = $studentName;
        $crawler = $client->request('GET', '/search?search_student=' . $studentName);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertLessThan(
            1,
            $crawler->filter('html:contains(' . $studentName . ')')->count()
        );
    }
}