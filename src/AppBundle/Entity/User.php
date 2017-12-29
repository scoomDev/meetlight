<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Collab;
use AppBundle\Entity\CollabRequest;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Note;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="ml_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     * @ORM\Column(name="street_number", type="string")
     */
    private $streetNumber;

    /**
     * @var string
     * @ORM\Column(name="route", type="string")
     */
    private $route;

    /**
     * @var string
     * @ORM\Column(name="locality", type="string")
     */
    private $locality;

    /**
     * @var string
     * @ORM\Column(name="country", type="string")
     */
    private $country;

    /**
     * @var int
     * @ORM\Column(name="lat", type="float")
     */
    private $lat;

    /**
     * @var int
     * @ORM\Column(name="lng", type="float")
     */
    private $lng;

    /**
     * @var Skill
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Skill")
     */
    private $skill;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @var Image
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Image", mappedBy="user")
     */
    private $images;

    /**
     * @var Collab
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Collab", mappedBy="userFrom")
     */
    private $collabOwner;

    /**
     * @var Collab
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Collab", mappedBy="userTo")
     */
    private $collabGuest;

    /**
     * @var Comment
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="user")
     */
    private $comments;

    /**
     * @var Note
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Note", mappedBy="user")
     */
    private $notes;

    /**
     * @var CollabRequest
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CollabRequest", mappedBy="user")
     */
    private $collabRequest;


    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setImageName('default-avatar.jpg');
        $this->images = new ArrayCollection();
        $this->collabOwner = new ArrayCollection();
        $this->collabGuest = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->collabRequest = new ArrayCollection();
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set streetNumber
     *
     * @param string $streetNumber
     *
     * @return User
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    /**
     * Get streetNumber
     *
     * @return string
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * Set route
     *
     * @param string $route
     *
     * @return User
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set locality
     *
     * @param string $locality
     *
     * @return User
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Get locality
     *
     * @return string
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set lat
     *
     * @param float $lat
     *
     * @return User
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param float $lng
     *
     * @return User
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return User
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set skill
     *
     * @param Skill $skill
     *
     * @return User
     */
    public function setSkill(Skill $skill = null)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return Skill
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * Add image
     *
     * @param Image $image
     *
     * @return User
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
     * Add collabOwner
     *
     * @param Collab $collabOwner
     *
     * @return User
     */
    public function addCollabOwner(Collab $collabOwner)
    {
        $this->collabOwner[] = $collabOwner;

        return $this;
    }

    /**
     * Remove collabOwner
     *
     * @param Collab $collabOwner
     */
    public function removeCollabOwner(Collab $collabOwner)
    {
        $this->collabOwner->removeElement($collabOwner);
    }

    /**
     * Get collabOwner
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollabOwner()
    {
        return $this->collabOwner;
    }

    /**
     * Add collabGuest
     *
     * @param Collab $collabGuest
     *
     * @return User
     */
    public function addCollabGuest(Collab $collabGuest)
    {
        $this->collabGuest[] = $collabGuest;

        return $this;
    }

    /**
     * Remove collabGuest
     *
     * @param Collab $collabGuest
     */
    public function removeCollabGuest(Collab $collabGuest)
    {
        $this->collabGuest->removeElement($collabGuest);
    }

    /**
     * Get collabGuest
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollabGuest()
    {
        return $this->collabGuest;
    }

    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return User
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
     * Add note
     *
     * @param Note $note
     *
     * @return User
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
     * Add collabRequest
     *
     * @param CollabRequest $collabRequest
     *
     * @return User
     */
    public function addCollabRequest(CollabRequest $collabRequest)
    {
        $this->collabRequest[] = $collabRequest;

        return $this;
    }

    /**
     * Remove collabRequest
     *
     * @param CollabRequest $collabRequest
     */
    public function removeCollabRequest(CollabRequest $collabRequest)
    {
        $this->collabRequest->removeElement($collabRequest);
    }

    /**
     * Get collabRequest
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollabRequest()
    {
        return $this->collabRequest;
    }
}
