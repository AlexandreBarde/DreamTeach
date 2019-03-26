<?php
/**
 * Created by PhpStorm.
 * User: Chloé Lewandowski
 * Date: 22/03/2019
 * Time: 11:07
 */

namespace App\Tests;

use App\Controller\DefaultController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function testShowRegister(){

        $client = static::createClient();
        $client->request('GET', '/register');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
