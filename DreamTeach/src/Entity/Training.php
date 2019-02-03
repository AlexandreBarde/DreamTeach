<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Training
 *
 * @ORM\Table(name="training", indexes={@ORM\Index(name="schoolID", columns={"schoolID"})})
 * @ORM\Entity
 */
class Training
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
     * @ORM\Column(name="title", type="string", length=40, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=20, nullable=false)
     */
    private $duration;

    /**
     * @var \School
     *
     * @ORM\ManyToOne(targetEntity="School")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="schoolID", referencedColumnName="id")
     * })
     */
    private $schoolid;


}
