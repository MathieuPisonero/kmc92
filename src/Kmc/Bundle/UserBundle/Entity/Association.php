<?php

namespace Kmc\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Association
 *
 * @ORM\Table(name="association")
 * @ORM\Entity(repositoryClass="Kmc\Bundle\UserBundle\Entity\Repository\AssociationRepository")
 */
class Association
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
     * @ORM\Column(name="adress1", type="string", length=255, nullable=true)
     */
    private $adress1;

    /**
     * @var string
     *
     * @ORM\Column(name="adress2", type="string", length=255, nullable=true)
     */
    private $adress2;

    /**
     * @var int
     *
     * @ORM\Column(name="zipcode", type="integer", nullable=true)
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;
    
    /**
     * @var int
     *
     * @ORM\Column(name="phone", type="integer", nullable=true)
     */
    private $phone;
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="Association")
     * @ORM\JoinColumn(nullable=true)
     */
    private $parentclub;


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
     * @return Association
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
     * Set adress1
     *
     * @param string $adress1
     *
     * @return Association
     */
    public function setAdress1($adress1)
    {
        $this->adress1 = $adress1;

        return $this;
    }

    /**
     * Get adress1
     *
     * @return string
     */
    public function getAdress1()
    {
        return $this->adress1;
    }

    /**
     * Set adress2
     *
     * @param string $adress2
     *
     * @return Association
     */
    public function setAdress2($adress2)
    {
        $this->adress2 = $adress2;

        return $this;
    }

    /**
     * Get adress2
     *
     * @return string
     */
    public function getAdress2()
    {
        return $this->adress2;
    }

    /**
     * Set zipcode
     *
     * @param integer $zipcode
     *
     * @return Association
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return int
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Association
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
     * Set logo
     *
     * @param string $logo
     *
     * @return Association
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }
    
    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return Association
     */
    public function setPhone($phone)
    {
    	$this->phone= $phone;
    	
    	return $this;
    }
    
    /**
     * Get zipcode
     *
     * @return int
     */
    public function getPhone()
    {
    	return $this->phone;
    }
    
    /**
     * Set user
     *
     * @param \Kmc\Bundle\UserBundle\Entity\User $user
     * @return Association
     */
    public function setUser(\Kmc\Bundle\UserBundle\Entity\User $user = null)
    {
    	$this->user = $user;
    	
    	return $this;
    }
    
    /**
     * Get user
     *
     * @return \Kmc\Bundle\UserBundle\Entity\Association
     */
    public function getUser()
    {
    	return $this->user;
    }
    
    /**
     * Set association
     *
     * @param \Kmc\Bundle\UserBundle\Entity\Association $association
     * @return Association
     */
    public function setParentClub(\Kmc\Bundle\UserBundle\Entity\Association $association= null)
    {
    	$this->parentclub= $association;
    	
    	return $this;
    }
    
    /**
     * Get user
     *
     * @return \Kmc\Bundle\UserBundle\Entity\Association
     */
    public function getParentClub()
    {
    	return $this->parentclub;
    }
}

