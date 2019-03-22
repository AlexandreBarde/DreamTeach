<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResponseRepository")
 */
class Response
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rightanswer;

    /**
     * @ORM\ManyToOne(targetEntity="Question")
     */
    private $question_id;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRightanswer(): ?bool
    {
        return $this->rightanswer;
    }

    public function setRightanswer(bool $rightanswer): self
    {
        $this->rightanswer = $rightanswer;

        return $this;
    }

    public function getQuestionId(): ?question
    {
        return $this->question_id;
    }

    public function setQuestionId(?question $question_id): self
    {
        $this->question_id = $question_id;

        return $this;
    }
}
