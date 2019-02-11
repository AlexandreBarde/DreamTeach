<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subjectlevel
 *
 * @ORM\Table(name="subjectlevel", indexes={@ORM\Index(name="IDX_550538D35621423", columns={"subjectID"}), @ORM\Index(name="IDX_550538D3A3D10F50", columns={"studentID"})})
 * @ORM\Entity
 */
class Subjectlevel
{
    /**
     * @var int
     *
     * @ORM\Column(name="subjectLvlID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $subjectlvlid;

    /**
     * @var int
     *
     * @ORM\Column(name="mark", type="integer", nullable=false)
     */
    private $mark;

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
     * @var \Student
     *
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="studentID", referencedColumnName="id")
     * })
     */
    private $studentid;

    public function getSubjectlvlid(): ?int
    {
        return $this->subjectlvlid;
    }

    public function getMark(): ?int
    {
        return $this->mark;
    }

    public function setMark(int $mark): self
    {
        $this->mark = $mark;

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

    public function getStudentid(): ?Student
    {
        return $this->studentid;
    }

    public function setStudentid(?Student $studentid): self
    {
        $this->studentid = $studentid;

        return $this;
    }


}
