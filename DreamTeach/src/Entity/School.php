<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * School
 *
 * @ORM\Table(name="school")
 * @ORM\Entity
 */
class School
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=40, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=50, nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCode", type="string", length=5, nullable=false)
     */
    private $postalcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=30, nullable=false)
     */
    private $city;


}
