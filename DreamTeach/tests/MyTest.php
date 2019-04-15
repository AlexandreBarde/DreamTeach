<?php

use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 22/03/19
 * Time: 16:12
 */
class MyTest extends TestCase
{

    public function test()
    {
        $this->assertEquals(100, 100);
    }

    public function testLogin()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $form = $client->getResponse()->getContent()->selectButton('submit')->form();

// set some values
        $form['emailaddress'] = 'rf@rf.fr';
        $form['password'] = 'robotframework';

// submit the form
        $crawler = $client->submit($form);
        $this->assertContains(
            'Dashboard',
            $client->getResponse()->getContent()
        );
    }

    public function testShowPost()
    {
        $client = static::createClient( array(), array(
            'HTTP_HOST' => 'trio2', // Set HOST HTTP Header.
            'HTTP_USER_AGENT' => 'Symfony Browser/1.0', // Set Agent header.
        ));

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}