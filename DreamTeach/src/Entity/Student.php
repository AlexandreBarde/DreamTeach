<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="student", indexes={@ORM\Index(name="trainingID", columns={"trainingID"})})
 * @ORM\Entity
 */
class Student
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
     * @ORM\Column(name="lastName", type="string", length=40, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=40, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="emailAddress", type="string", length=60, nullable=false)
     */
    private $emailaddress;

    /**
     * @var string
     *
     * @ORM\Column(name="biography", type="string", length=255, nullable=false)
     */
    private $biography;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=20, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=100, nullable=false)
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="xpWon", type="string", length=5, nullable=false)
     */
    private $xpwon;

    /**
     * @var \Training
     *
     * @ORM\ManyToOne(targetEntity="Training")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="trainingID", referencedColumnName="id")
     * })
     */
    private $trainingid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Badge", inversedBy="studentid")
     * @ORM\JoinTable(name="givenrecompenses",
     *   joinColumns={
     *     @ORM\JoinColumn(name="studentID", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="badgeID", referencedColumnName="id")
     *   }
     * )
     */
    private $badgeid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Session", mappedBy="studentid")
     */
    private $sessionid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Subject", inversedBy="studentid")
     * @ORM\JoinTable(name="subjectlevel",
     *   joinColumns={
     *     @ORM\JoinColumn(name="studentID", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="subjectID", referencedColumnName="id")
     *   }
     * )
     */
    private $subjectid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->badgeid = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sessionid = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subjectid = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
