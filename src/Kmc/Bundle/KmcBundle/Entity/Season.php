<?php

namespace Kmc\Bundle\KmcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Season
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Season
{
    /**
     * @var integer
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
     * @var \DateTime
     *
     * @ORM\Column(name="seasonstart", type="datetime")
     */
    private $seasonstart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="seasonend", type="datetime")
     */
    private $seasonend;

    public function __toString()
    {
    	return $this->name;
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Season
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
     * Set year
     *
     * @param \DateTime $year
     * @return Season
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return \DateTime 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set seasonstart
     *
     * @param \DateTime $seasonstart
     * @return Season
     */
    public function setSeasonstart($seasonstart)
    {
        $this->seasonstart = $seasonstart;

        return $this;
    }

    /**
     * Get seasonstart
     *
     * @return \DateTime 
     */
    public function getSeasonstart()
    {
        return $this->seasonstart;
    }

    /**
     * Set seasonend
     *
     * @param \DateTime $seasonend
     * @return Season
     */
    public function setSeasonend($seasonend)
    {
        $this->seasonend = $seasonend;

        return $this;
    }

    /**
     * Get seasonend
     *
     * @return \DateTime 
     */
    public function getSeasonend()
    {
        return $this->seasonend;
    }
}
