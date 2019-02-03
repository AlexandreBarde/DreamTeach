<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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

}
