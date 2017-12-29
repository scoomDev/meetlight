<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Collab;
use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table(name="ml_note")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NoteRepository")
 */
class Note
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
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    private $note;

    /**
     * @var Collab
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Collab", inversedBy="notes")
     */
    private $collab;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="notes")
     */
    private $user;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $userFrom;

    /**
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var bool
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;


    public function __construct()
    {
        $this->status = false;
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
     * Set note
     *
     * @param integer $note
     *
     * @return Note
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set collab
     *
     * @param Collab $collab
     *
     * @return Note
     */
    public function setCollab(Collab $collab = null)
    {
        $this->collab = $collab;

        return $this;
    }

    /**
     * Get collab
     *
     * @return Collab
     */
    public function getCollab()
    {
        return $this->collab;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Note
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param User $userFrom
     *
     * @return Note
     */
    public function setUserFrom(User $userFrom = null)
    {
        $this->userFrom = $userFrom;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     */
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }
}
