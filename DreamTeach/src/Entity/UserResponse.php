<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserResponseRepository")
 */
class UserResponse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="responses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QuestionList")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question_list_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Response")
     * @ORM\JoinColumn(nullable=false)
     */
    private $response_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?Student
    {
        return $this->user_id;
    }

    public function setUserId(?Student $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getQuestionListId(): ?QuestionList
    {
        return $this->question_list_id;
    }

    public function setQuestionListId(?QuestionList $question_list_id): self
    {
        $this->question_list_id = $question_list_id;

        return $this;
    }

    public function getResponseId(): ?response
    {
        return $this->response_id;
    }

    public function setResponseId(?response $response_id): self
    {
        $this->response_id = $response_id;

        return $this;
    }

}
