<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmailaddress(): ?string
    {
        return $this->emailaddress;
    }

    public function setEmailaddress(string $emailaddress): self
    {
        $this->emailaddress = $emailaddress;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getXpwon(): ?string
    {
        return $this->xpwon;
    }

    public function setXpwon(string $xpwon): self
    {
        $this->xpwon = $xpwon;

        return $this;
    }

    public function getTrainingid(): ?Training
    {
        return $this->trainingid;
    }

    public function setTrainingid(?Training $trainingid): self
    {
        $this->trainingid = $trainingid;

        return $this;
    }

    /**
     * @return Collection|Badge[]
     */
    public function getBadgeid(): Collection
    {
        return $this->badgeid;
    }

    public function addBadgeid(Badge $badgeid): self
    {
        if (!$this->badgeid->contains($badgeid)) {
            $this->badgeid[] = $badgeid;
        }

        return $this;
    }

    public function removeBadgeid(Badge $badgeid): self
    {
        if ($this->badgeid->contains($badgeid)) {
            $this->badgeid->removeElement($badgeid);
        }

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessionid(): Collection
    {
        return $this->sessionid;
    }

    public function addSessionid(Session $sessionid): self
    {
        if (!$this->sessionid->contains($sessionid)) {
            $this->sessionid[] = $sessionid;
            $sessionid->addStudentid($this);
        }

        return $this;
    }

    public function removeSessionid(Session $sessionid): self
    {
        if ($this->sessionid->contains($sessionid)) {
            $this->sessionid->removeElement($sessionid);
            $sessionid->removeStudentid($this);
        }

        return $this;
    }

    /**
     * @return Collection|Subject[]
     */
    public function getSubjectid(): Collection
    {
        return $this->subjectid;
    }

    public function addSubjectid(Subject $subjectid): self
    {
        if (!$this->subjectid->contains($subjectid)) {
            $this->subjectid[] = $subjectid;
        }

        return $this;
    }

    public function removeSubjectid(Subject $subjectid): self
    {
        if ($this->subjectid->contains($subjectid)) {
            $this->subjectid->removeElement($subjectid);
        }

        return $this;
    }

}
