<?php

namespace Kmc\Bundle\KmcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Club
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Club
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
 * @var string
 *
 * @ORM\Column(name="city", type="string", length=255)
 */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="City", mappedBy="club" )
     * @ORM\JoinColumn(name="citys", referencedColumnName="id")
     **/
    protected $citys;

    /**
     * @var integer
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;
    
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
     * @return Club
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
     * Set city
     *
     * @param string $city
     * @return Club
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set image
     *
     * @param integer $image
     * @return Club
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return integer 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get members
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Add citys
     *
     * @param \Kmc\Bundle\KmcBundle\Entity\City $citys
     * @return Club
     */
    public function addCity(\Kmc\Bundle\KmcBundle\Entity\City $citys)
    {
        $this->citys[] = $citys;

        return $this;
    }

    /**
     * Remove citys
     *
     * @param \Kmc\Bundle\KmcBundle\Entity\City $citys
     */
    public function removeCity(\Kmc\Bundle\KmcBundle\Entity\City $citys)
    {
        $this->citys->removeElement($citys);
    }

    /**
     * Get citys
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCitys()
    {
        return $this->citys;
    }
}
