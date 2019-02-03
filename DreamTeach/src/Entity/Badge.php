<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    public function getId(): ?int
    {
        return $this->id;
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
            $studentid->addBadgeid($this);
        }

        return $this;
    }

    public function removeStudentid(Student $studentid): self
    {
        if ($this->studentid->contains($studentid)) {
            $this->studentid->removeElement($studentid);
            $studentid->removeBadgeid($this);
        }

        return $this;
    }

}
