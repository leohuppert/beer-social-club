<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Beer
 *
 * @ORM\Table(name="beer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BeerRepository")
 */
class Beer
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="degree", type="decimal", precision=5, scale=1)
     */
    private $degree;

    /**
     * @var string
     *
     * @ORM\Column(name="brewer", type="string", length=255)
     */
    private $brewer;

    /**
     * @var BeerType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BeerType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

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
     * Set name
     *
     * @param string $name
     *
     * @return Beer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set degree
     *
     * @param string $degree
     *
     * @return Beer
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;

        return $this;
    }

    /**
     * Get degree
     *
     * @return string
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * Set brewer
     *
     * @param string $brewer
     *
     * @return Beer
     */
    public function setBrewer($brewer)
    {
        $this->brewer = $brewer;

        return $this;
    }

    /**
     * Get brewer
     *
     * @return string
     */
    public function getBrewer()
    {
        return $this->brewer;
    }

    /**
     * @return BeerType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param BeerType $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    function __toString()
    {
        return $this->getName();
    }
}

