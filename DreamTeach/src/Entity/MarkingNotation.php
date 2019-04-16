<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarkingNotationRepository")
 */
class MarkingNotation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="session", referencedColumnName="id")
     * })
     * @ORM\ManyToOne(targetEntity="Session")
     */
    private $session;

    /**
     *
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="student", referencedColumnName="id")
     * })
     * @ORM\ManyToOne(targetEntity="Student")
     */
    private $student;

    /**
     * @ORM\Column(type="integer")
     */
    private $markingEfficiency;

    /**
     * @ORM\Column(type="integer")
     */
    private $markingAmbience;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param mixed $session
     */
    public function setSession($session): void
    {
        $this->session = $session;
    }

    /**
     * @return mixed
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param mixed $student
     */
    public function setStudent($student): void
    {
        $this->student = $student;
    }

    /**
     * @return mixed
     */
    public function getMarkingEfficiency()
    {
        return $this->markingEfficiency;
    }

    /**
     * @param mixed $markingEfficiency
     */
    public function setMarkingEfficiency($markingEfficiency): void
    {
        $this->markingEfficiency = $markingEfficiency;
    }

    /**
     * @return mixed
     */
    public function getMarkingAmbience()
    {
        return $this->markingAmbience;
    }

    /**
     * @param mixed $markingAmbience
     */
    public function setMarkingAmbience($markingAmbience): void
    {
        $this->markingAmbience = $markingAmbience;
    }


}