<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class FriendshipRelation
 * @ORM\Table(name="friendship_relation")
 *
 * @ORM\Entity(repositoryClass="App\Repository\FriendshipRelationRepository")
 */
class FriendshipRelation
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
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="relations", cascade="persist")
     * Celui qui ajoute l'ami, l'user en cours !!!!
     */
    private $student_1;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="relations", cascade="persist")
     */
    private $student_2;

    /**
     * @var boolean
     * @ORM\Column(name="is_accepted", type="boolean")
     */
    private $is_accepted;

    /**
     * FriendshipRelation constructor.
     * @param bool $is_accepted
     */
    public function __construct($is_accepted = 0)
    {
        $this->is_accepted = $is_accepted;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getStudent1()
    {
        return $this->student_1;
    }

    /**
     * @param mixed $student_1
     */
    public function setStudent1($student_1): void
    {
        $this->student_1 = $student_1;
    }

    /**
     * @return mixed
     */
    public function getStudent2()
    {
        return $this->student_2;
    }

    /**
     * @param mixed $student_2
     */
    public function setStudent2($student_2): void
    {
        $this->student_2 = $student_2;
    }

    /**
     * @return bool
     */
    public function isAccepted(): bool
    {
        return $this->is_accepted;
    }

    /**
     * @param bool $is_accepted
     */
    public function setIsAccepted(bool $is_accepted): void
    {
        $this->is_accepted = $is_accepted;
    }

    public function getIsAccepted(): ?bool
    {
        return $this->is_accepted;
    }



}