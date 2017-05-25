<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Liking
 *
 * @ORM\Table(name="liking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LikingRepository")
 */
class Liking
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
     * @ORM\Column(name="rating", type="decimal", precision=5, scale=1)
     */
    private $rating;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255)
     */
    private $comment;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @var Beer
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Beer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $beer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     */
    private $date;

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
     * Set rating
     *
     * @param string $rating
     *
     * @return Liking
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Liking
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    /**
     * @return Beer
     */
    public function getBeer()
    {
        return $this->beer;
    }

    /**
     * @param Beer $beer
     */
    public function setBeer(Beer $beer)
    {
        $this->beer = $beer;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }
}
