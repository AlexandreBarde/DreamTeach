<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Scalar\String_;

/**
 * Session
 * @ORM\Table(name="sessionparticipants", indexes={@ORM\Index(name="sessionID", columns={"sessionID"}), @ORM\Index(name="studentID", columns={"studentID"})})
 * @ORM\Entity(repositoryClass="App\Repository\SessionParticipantsRepository")
 */
class SessionParticipants
{
    /**
     * @var int
     *
     * @ORM\Column(name="sessionParticipantsID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sessionParticpantsid;


    /**
     * @var \Session
     *
     * @ORM\ManyToOne(targetEntity="Session")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sessionID", referencedColumnName="id")
     * })
     */
    private $sessionid;

    /**
     * @var \Student
     *
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="studentID", referencedColumnName="id")
     * })
     */
    private $studentid;

    /**
     * @return int
     */
    public function getSessionParticpantsid(): int
    {
        return $this->sessionParticpantsid;
    }

    /**
     * @param int $sessionParticpantsid
     */
    public function setSessionParticpantsid(int $sessionParticpantsid): void
    {
        $this->sessionParticpantsid = $sessionParticpantsid;
    }

    /**
     * @return \Session
     */
    public function getSessionid(): \Session
    {
        return $this->sessionid;
    }

    /**
     * @param \Session $sessionid
     */
    public function setSessionid(\Session $sessionid): void
    {
        $this->sessionid = $sessionid;
    }

    /**
     * @return \Student
     */
    public function getStudentid(): \Student
    {
        return $this->studentid;
    }

    /**
     * @param \Student $studentid
     */
    public function setStudentid(\Student $studentid): void
    {
        $this->studentid = $studentid;
    }



}
?>