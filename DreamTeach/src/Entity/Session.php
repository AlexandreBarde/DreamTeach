<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Session
 *
 * @ORM\Table(name="session", indexes={@ORM\Index(name="subjectID", columns={"subjectID"}), @ORM\Index(name="organizerID", columns={"organizerID"})})
 * @ORM\Entity(repositoryClass="App\Repository\SessionRepository")
 */
class Session
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
     * @var \DateTime
     *
     * @ORM\Column(name="startingTime", type="time", nullable=false)
     */
    private $startingtime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endingTime", type="time", nullable=false)
     */
    private $endingtime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=100, nullable=true)
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @var int
     *
     * @ORM\Column(name="maxNbParticipant", type="integer", nullable=false)
     */
    private $maxnbparticipant;

    /**
     * @var bool
     *
     * @ORM\Column(name="isVirtual", type="boolean", nullable=false)
     */
    private $isvirtual;

    /**
     * @var string
     *
     * @ORM\Column(name="vocalSoftware", type="string", length=100, nullable=true)
     */
    private $vocalSoftware;

    /**
     * @var \Student
     *
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="organizerID", referencedColumnName="id")
     * })
     */
    private $organizerid;

    /**
     * @var \Subject
     *
     * @ORM\ManyToOne(targetEntity="Subject")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subjectID", referencedColumnName="id")
     * })
     */
    private $subjectid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Student", inversedBy="sessionid")
     * @ORM\JoinTable(name="sessionparticipants",
     *   joinColumns={
     *     @ORM\JoinColumn(name="sessionID", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="studentID", referencedColumnName="id")
     *   }
     * )
     */
    private $studentid;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $closed;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartingtime(): ?\DateTimeInterface
    {
        return $this->startingtime;
    }

    public function setStartingtime(\DateTimeInterface $startingtime): self
    {
        $this->startingtime = $startingtime;

        return $this;
    }

    public function getEndingtime(): ?\DateTimeInterface
    {
        return $this->endingtime;
    }

    public function setEndingtime(\DateTimeInterface $endingtime): self
    {
        $this->endingtime = $endingtime;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getMaxnbparticipant(): ?int
    {
        return $this->maxnbparticipant;
    }

    public function setMaxnbparticipant(int $maxnbparticipant): self
    {
        $this->maxnbparticipant = $maxnbparticipant;

        return $this;
    }

    public function getIsvirtual(): ?bool
    {
        return $this->isvirtual;
    }

    public function setIsvirtual(bool $isvirtual): self
    {
        $this->isvirtual = $isvirtual;

        return $this;
    }

    public function getOrganizerid(): \Student
    {
        return $this->organizerid;
    }

    public function setOrganizerid(?Student $organizerid): self
    {
        $this->organizerid = $organizerid;

        return $this;
    }

    public function getSubjectid(): ?Subject
    {
        return $this->subjectid;
    }

    public function setSubjectid(?Subject $subjectid): self
    {
        $this->subjectid = $subjectid;

        return $this;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudentid(): Collection
    {
        return $this->studentid;
    }

    public function addStudentid(Student $studentid): self
    {
        if (!$this->studentid->contains($studentid)) {
            $this->studentid[] = $studentid;
        }

        return $this;
    }

    public function removeStudentid(Student $studentid): self
    {
        if ($this->studentid->contains($studentid)) {
            $this->studentid->removeElement($studentid);
        }

        return $this;
    }

    public function setStudentid(Student $studentid)
    {
        $this->studentid = $studentid;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getVocalSoftware()
    {
        return $this->vocalSoftware;
    }

    /**
     * @param string $vocalSoftware
     */
    public function setVocalSoftware(string $vocalSoftware): void
    {
        $this->vocalSoftware = $vocalSoftware;
    }

    public function getClosed(): ?bool
    {
        return $this->closed;
    }

    public function setClosed(bool $closed): self
    {
        $this->closed = $closed;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }





}
