<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Scalar\String_;

/**
 * Session
 *
 * @ORM\Table(name="session", indexes={@ORM\Index(name="subjectID", columns={"subjectID"}), @ORM\Index(name="organizerID", columns={"organizerID"})})
 * @ORM\Entity
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=false)
     */
    private $description;

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
     * @ORM\Column(name="place", type="string", length=100, nullable=false)
     */
    private $place;

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
     * Constructor
     */
    public function __construct()
    {
        $this->studentid = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    public function getOrganizerid(): ?Student
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

}
