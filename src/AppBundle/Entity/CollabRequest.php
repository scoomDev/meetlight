<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Collab;
use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * CollabRequest
 *
 * @ORM\Table(name="ml_collab_request")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CollabRequestRepository")
 */
class CollabRequest
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
     * @var string
     *
     * @ORM\Column(name="is_accepted", type="boolean")
     */
    private $isAccepted;

    /**
     * @var string
     *
     * @ORM\Column(name="is_refused", type="boolean")
     */
    private $isRefused;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="collabRequest")
     */
    private $user;

    /**
     * @var Collab
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Collab")
     */
    private $collab;

    /**
     * CollabRequest constructor.
     */
    public function __construct()
    {
        $this->isAccepted = false;
        $this->isRefused = false;
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
     * Set isAccepted
     *
     * @param string $isAccepted
     *
     * @return CollabRequest
     */
    public function setIsAccepted($isAccepted)
    {
        $this->isAccepted = $isAccepted;

        return $this;
    }

    /**
     * Get isAccepted
     *
     * @return string
     */
    public function getIsAccepted()
    {
        return $this->isAccepted;
    }

    /**
     * Set isRefused
     *
     * @param string $isRefused
     *
     * @return CollabRequest
     */
    public function setIsRefused($isRefused)
    {
        $this->isRefused = $isRefused;

        return $this;
    }

    /**
     * Get isRefused
     *
     * @return string
     */
    public function getIsRefused()
    {
        return $this->isRefused;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return CollabRequest
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
     * Set collab
     *
     * @param Collab $collab
     *
     * @return CollabRequest
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
}
