<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Badge
 *
 * @ORM\Table(name="badge")
 * @ORM\Entity
 */
class Badge
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
     * @ORM\Column(name="name", type="string", length=30, nullable=false)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Student", mappedBy="badgeid")
     */
    private $studentid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->studentid = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
