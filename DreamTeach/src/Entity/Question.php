<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question", indexes={@ORM\Index(name="IDX_B6F7494EF675F31B", columns={"author_id"}), @ORM\Index(name="theme", columns={"theme"})})
 * @ORM\Entity
 */
class Question
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
     *
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="qcm", referencedColumnName="id")
     * })
     * @ORM\ManyToOne(targetEntity="Qcm")
     */
    private $qcm;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=1000, nullable=false)
     */
    private $content;

    /**
     * @var Student
     *
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     * })
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="Response", mappedBy="question_id", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $responses;

    /**
     * @var Theme
     *
     * @ORM\ManyToOne(targetEntity="Theme", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="theme", referencedColumnName="id")
     * })
     */
    private $theme;

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

    public function getAuthor(): ?Student
    {
        return $this->author;
    }

    public function setAuthor(?Student $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Response[]
     */
    public function getResponses()
    {
        return $this->responses;
    }

    public function addResponses(Response $response): self
    {
        $this->responses[] = $response;
        $response->setQuestionId($this);

        return $this;
    }

    public function setResponses(Response $response)
    {
        $this->responses[] = $response;
        $response->setQuestionId($this);

        return $this;
    }



    public function removeResponses(Response $response): self
    {
        if ($this->responses->contains($response)) {
            $this->responses->removeElement($response);
            // set the owning side to null (unless already changed)
            if ($response->getQuestionId() === $this) {
                $response->setQuestionId(null);
            }
        }
        return $this;
    }

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQcm()
    {
        return $this->qcm;
    }

    /**
     * @param mixed $qcm
     */
    public function setQcm($qcm): void
    {
        $this->qcm = $qcm;
    }



}
