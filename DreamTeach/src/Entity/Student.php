<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Student
 *
 * @ORM\Table(name="student", indexes={@ORM\Index(name="trainingID", columns={"trainingID"})})
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 * @UniqueEntity("emailaddress", message = "L'email que vous avez entré est déjà utilisé")
 */
class Student implements UserInterface
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
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $uuid;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="emailAddress", type="string", length=255, nullable=false)
     */
    private $emailaddress;

    /**
     * @var string
     *
     * @ORM\Column(name="biography", type="string", length=255, nullable=true)
     */
    private $biography = null;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @Assert\Length(min="8", minMessage="min 8 caractères")
     */
    private $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     */
    private $avatar = null;

    /**
     * @var integer
     *
     * @ORM\Column(name="xpWon", type="integer", nullable=true)
     */
    private $xpwon = 0;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Training")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="trainingID", referencedColumnName="id", nullable=true)
     * })
     */
    private $trainingid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Badge", inversedBy="studentid")
     * @ORM\JoinTable(name="givenrecompenses",
     *   joinColumns={
     *     @ORM\JoinColumn(name="studentID", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="badgeID", referencedColumnName="id")
     *   }
     * )
     */
    private $badgeid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Session", mappedBy="studentid")
     */
    private $sessionid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Subject", inversedBy="studentid")
     * @ORM\JoinTable(name="subject_level",
     *   joinColumns={
     *     @ORM\JoinColumn(name="studentID", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="subjectID", referencedColumnName="id")
     *   }
     * )
     */
    private $subjectid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Student", inversedBy="studentid")
     * @ORM\JoinTable(name="liked_profile",
     *   joinColumns={
     *     @ORM\JoinColumn(name="studentID1", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="studentID2", referencedColumnName="id")
     *   }
     * )
     */
    private $studentid;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthDate;

    /**
     * @ORM\OneToMany(targetEntity="FriendshipRelation", mappedBy="student_2")
     */
    private $relations;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $resetPassword;

    /**
     * @return mixed
     */
    public function getResetId()
    {
        return $this->resetId;
    }

    /**
     * @param mixed $resetId
     */
    public function setResetId($resetId): void
    {
        $this->resetId = $resetId;
    }

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resetId;

    /**
     * @return mixed
     */
    public function getResetPassword()
    {
        return $this->resetPassword;
    }

    /**
     * @param mixed $resetPassword
     */
    public function setResetPassword($resetPassword): void
    {
        $this->resetPassword = $resetPassword;
    }

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Grade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="gradeId", referencedColumnName="id", nullable=true)
     * })
     */
    private $gradeid;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="author", orphanRemoval=true)
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Qcm", mappedBy="author_id", orphanRemoval=true)
     */
    private $qcms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserResponse", mappedBy="user_id", orphanRemoval=true)
     */
    private $responses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FileUpload", mappedBy="idStudent", orphanRemoval=true)
     */
    private $fileUploads;


    /**
     * Constructor
     * @throws \Exception
     */
    public function __construct()
    {
        $this->badgeid = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sessionid = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subjectid = new \Doctrine\Common\Collections\ArrayCollection();
        $this->xpwon = 0;
        $this->uuid = Uuid::uuid4()->toString();
        $this->relations = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->qcms = new ArrayCollection();
        $this->responses = new ArrayCollection();
        $this->fileUploads = new ArrayCollection();
        $this->studentid = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmailaddress(): ?string
    {
        return $this->emailaddress;
    }

    public function setEmailaddress(string $emailaddress): self
    {
        $this->emailaddress = $emailaddress;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function getXpwon()
    {
        return $this->xpwon;
    }

    public function setXpwon(int $xpwon): self
    {
        $this->xpwon = $xpwon;

        return $this;
    }

    public function getTrainingid()
    {
        return $this->trainingid;
    }

    public function setTrainingid(?Training $trainingid): self
    {
        $this->trainingid = $trainingid;

        return $this;
    }

    /**
     * @return Collection|Badge[]
     */
    public function getBadgeid(): Collection
    {
        return $this->badgeid;
    }

    public function addBadgeid(Badge $badgeid): self
    {
        if (!$this->badgeid->contains($badgeid)) {
            $this->badgeid[] = $badgeid;
        }

        return $this;
    }

    public function removeBadgeid(Badge $badgeid): self
    {
        if ($this->badgeid->contains($badgeid)) {
            $this->badgeid->removeElement($badgeid);
        }

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessionid(): Collection
    {
        return $this->sessionid;
    }

    public function addSessionid(Session $sessionid): self
    {
        if (!$this->sessionid->contains($sessionid)) {
            $this->sessionid[] = $sessionid;
            $sessionid->addStudentid($this);
        }

        return $this;
    }

    public function removeSessionid(Session $sessionid): self
    {
        if ($this->sessionid->contains($sessionid)) {
            $this->sessionid->removeElement($sessionid);
            $sessionid->removeStudentid($this);
        }

        return $this;
    }

    public function setSessionid(Session $session)
    {
        $this->sessionid = $session;
    }

    /**
     * @return Collection|Subject[]
     */
    public function getSubjectid(): Collection
    {
        return $this->subjectid;
    }

    public function addSubjectid(Subject $subjectid): self
    {
        if (!$this->subjectid->contains($subjectid)) {
            $this->subjectid[] = $subjectid;
        }

        return $this;
    }

    public function removeSubjectid(Subject $subjectid): self
    {
        if ($this->subjectid->contains($subjectid)) {
            $this->subjectid->removeElement($subjectid);
        }

        return $this;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudentid(): Collection
    {
        return $this->studentid;
    }

    public function addStudentid(Student $studentid): self
    {
        if (!$this->subjectid->contains($studentid)) {
            $this->studentid[] = $studentid;
        }

        return $this;
    }

    public function removeStudentid(Student $studentid): self
    {
        if ($this->studentid->contains($studentid)) {
            $this->studenttid->removeElement($studentid);
        }

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->id;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getArray()
    {
        return array
        (
            'id' => $this->getId(),
            'email' => $this->getEmailaddress(),
            'lastname' => $this->getLastname(),
            'firstname' => $this->getFirstname(),
        );
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * @param mixed $relations
     */
    public function setRelations($relations)
    {
        $this->relations = $relations;
    }

    public function addRelation(FriendshipRelation $relation): self
    {
        if (!$this->relations->contains($relation)) {
            $this->relations[] = $relation;
            $relation->setStudent2($this);
        }

        return $this;
    }

    public function removeRelation(FriendshipRelation $relation): self
    {
        if ($this->relations->contains($relation)) {
            $this->relations->removeElement($relation);
            // set the owning side to null (unless already changed)
            if ($relation->getStudent2() === $this) {
                $relation->setStudent2(null);
            }
        }

        return $this;
    }

    public function getGradeid(): ?Grade
    {
        return $this->gradeid;
    }

    public function setGradeid(?Grade $gradeid): self
    {
        $this->gradeid = $gradeid;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setAuthor($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getAuthor() === $this) {
                $question->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Qcm[]
     */
    public function getQcms(): Collection
    {
        return $this->qcms;
    }

    public function addQcm(Qcm $qcm): self
    {
        if (!$this->qcms->contains($qcm)) {
            $this->qcms[] = $qcm;
            $qcm->setAuthorId($this);
        }

        return $this;
    }

    public function removeQcm(Qcm $qcm): self
    {
        if ($this->qcms->contains($qcm)) {
            $this->qcms->removeElement($qcm);
            // set the owning side to null (unless already changed)
            if ($qcm->getAuthorId() === $this) {
                $qcm->setAuthorId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserResponse[]
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->firstname . ' ' . $this->lastname;
    }

    public function addResponse(UserResponse $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses[] = $response;
            $response->setUserId($this);
        }

        return $this;
    }

    public function removeResponse(UserResponse $response): self
    {
        if ($this->responses->contains($response)) {
            $this->responses->removeElement($response);
            // set the owning side to null (unless already changed)
            if ($response->getUserId() === $this) {
                $response->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FileUpload[]
     */
    public function getFileUploads(): Collection
    {
        return $this->fileUploads;
    }

    public function addFileUpload(FileUpload $fileUpload): self
    {
        if (!$this->fileUploads->contains($fileUpload)) {
            $this->fileUploads[] = $fileUpload;
            $fileUpload->setIdStudent($this);
        }

        return $this;
    }

    public function removeFileUpload(FileUpload $fileUpload): self
    {
        if ($this->fileUploads->contains($fileUpload)) {
            $this->fileUploads->removeElement($fileUpload);
            // set the owning side to null (unless already changed)
            if ($fileUpload->getIdStudent() === $this) {
                $fileUpload->setIdStudent(null);
            }
        }

        return $this;
    }

}
