<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Image;
use AppBundle\Entity\Note;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Collab
 *
 * @ORM\Table(name="ml_collab")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CollabRepository")
 */
class Collab
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="started_at", type="datetime")
     */
    private $startedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finished_at", type="datetime")
     */
    private $finishedAt;

    /**
     * @var boolean
     * @ORM\Column(name="is_finished", type="boolean")
     */
    private $isFinished;

    /**
     * @var boolean
     * @ORM\Column(name="is_cancelled", type="boolean")
     */
    private $isCanceled;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="collabOwner")
     */
    private $userFrom;

    /**
     * @var User
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="collabGuest")
     */
    private $userTo;

    /**
     * @var Comment
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="collab")
     */
    private $comments;

    /**
     * @var Image
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Image", mappedBy="collab")
     */
    private $images;

    /**
     * @var Note
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Note", mappedBy="collab")
     */
    private $notes;

    /**
     * @var float
     * @ORM\Column(name="average_rating", type="float", nullable=true)
     */
    private $averageRating;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->startedAt = new \DateTime();
        $this->finishedAt = new \DateTime();
        $this->userTo = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->isFinished = false;
        $this->isCanceled = false;
        $this->averageRating = 0;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set startedAt
     *
     * @param \DateTime $startedAt
     *
     * @return Collab
     */
    public function setStartedAt($startedAt)
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    /**
     * Get startedAt
     *
     * @return \DateTime
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * Set finishedAt
     *
     * @param \DateTime $finishedAt
     *
     * @return Collab
     */
    public function setFinishedAt($finishedAt)
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    /**
     * Get finishedAt
     *
     * @return \DateTime
     */
    public function getFinishedAt()
    {
        return $this->finishedAt;
    }

    /**
     * Set userFrom
     *
     * @param User $userFrom
     *
     * @return Collab
     */
    public function setUserFrom(User $userFrom = null)
    {
        $this->userFrom = $userFrom;

        return $this;
    }

    /**
     * Get userFrom
     *
     * @return User
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }

    /**
     * Add userTo
     *
     * @param User $userTo
     *
     * @return Collab
     */
    public function addUserTo(User $userTo)
    {
        $this->userTo[] = $userTo;

        return $this;
    }

    /**
     * Remove userTo
     *
     * @param User $userTo
     */
    public function removeUserTo(User $userTo)
    {
        $this->userTo->removeElement($userTo);
    }

    /**
     * Get userTo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserTo()
    {
        return $this->userTo;
    }

    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return Collab
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add image
     *
     * @param Image $image
     *
     * @return Collab
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param Image $image
     */
    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add note
     *
     * @param Note $note
     *
     * @return Collab
     */
    public function addNote(Note $note)
    {
        $this->notes[] = $note;

        return $this;
    }

    /**
     * Remove note
     *
     * @param Note $note
     */
    public function removeNote(Note $note)
    {
        $this->notes->removeElement($note);
    }

    /**
     * Get notes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param bool $isFinished
     *
     * @return $this
     */
    public function setIsFinished(bool $isFinished)
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsFinished()
    {
        return $this->isFinished;
    }

    /**
     * @param bool $isCanceled
     *
     * @return $this
     */
    public function setIsCanceled(bool $isCanceled)
    {
        $this->isCanceled = $isCanceled;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsCanceled()
    {
        return $this->isCanceled;
    }

    /**
     * @return float
     */
    public function getAverageRating(): float
    {
        return $this->averageRating;
    }

    /**
     * @param float $averageRating
     */
    public function setAverageRating(float $averageRating)
    {
        $this->averageRating = $averageRating;
    }
}
