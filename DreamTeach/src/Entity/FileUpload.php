<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FileUploadRepository")
 */
class FileUpload
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="fileUploads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idStudent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Session", inversedBy="fileUploads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idSession;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdStudent(): ?Student
    {
        return $this->idStudent;
    }

    public function setIdStudent(?Student $idStudent): self
    {
        $this->idStudent = $idStudent;

        return $this;
    }

    public function getIdSession(): ?Session
    {
        return $this->idSession;
    }

    public function setIdSession(?Session $idSession): self
    {
        $this->idSession = $idSession;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }
}
