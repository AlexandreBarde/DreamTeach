<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarkingRepository")
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
}