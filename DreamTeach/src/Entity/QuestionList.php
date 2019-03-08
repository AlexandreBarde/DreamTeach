<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionListRepository")
 */
class QuestionList
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Qcm")
     * @ORM\JoinColumn(nullable=false)
     */
    private $qcm_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionId(): ?Question
    {
        return $this->question_id;
    }

    public function setQuestionId(?Question $question_id): self
    {
        $this->question_id = $question_id;

        return $this;
    }

    public function getQcmId(): ?Qcm
    {
        return $this->qcm_id;
    }

    public function setQcmId(?Qcm $qcm_id): self
    {
        $this->qcm_id = $qcm_id;

        return $this;
    }
}
