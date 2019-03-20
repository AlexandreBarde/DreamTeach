<?php
/**
 * Created by PhpStorm.
 * User: Alexandre
 * Date: 20/03/2019
 * Time: 18:09
 */

namespace App\EventListener;


use Doctrine\ORM\EntityManager;

class HangmanEventListener
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadEvents()
    {
        return "oui";
    }


}