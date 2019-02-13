<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Student", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idSender;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Student", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idReceiver;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdSender(): ?Student
    {
        return $this->idSender;
    }

    public function setIdSender(Student $idSender): self
    {
        $this->idSender = $idSender;

        return $this;
    }

    public function getIdReceiver(): ?Student
    {
        return $this->idReceiver;
    }

    public function setIdReceiver(Student $idReceiver): self
    {
        $this->idReceiver = $idReceiver;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
