<?php

namespace Kmc\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MemberSeason
 *
 * @ORM\Table(name="memberseason")
 * @ORM\Entity
 */
class MemberSeason
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
     * @ORM\ManyToOne(targetEntity="\Kmc\Bundle\AdminBundle\Entity\Member", inversedBy="seasons")
     * @ORM\JoinColumn(name="member", referencedColumnName="id")
     **/
    private $member;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Kmc\Bundle\KmcBundle\Entity\Season")
     **/
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="\Kmc\Bundle\KmcBundle\Entity\Price")
     **/
    private $price;
    
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
     * Set member
     *
     * @param \Kmc\Bundle\AdminBundle\Entity\Member $member
     * @return InformationSubscription
     */
    public function setMember(\Kmc\Bundle\AdminBundle\Entity\Member $member = null)
    {
    	$this->member = $member;
    
    	return $this;
    }
    
    
    /**
     * Get member
     *
     * @return \Kmc\Bundle\AdminBundle\Entity\Member
     */
    public function getMember()
    {
    	return $this->member;
    }
    
    /**
     * Set season
     *
     * @param \Kmc\Bundle\KmcBundle\Entity\Season $season
     * @return Season
     */
    public function setSeason(\Kmc\Bundle\KmcBundle\Entity\Season $season = null)
    {
    	$this->season = $season;
    	return $this;
    }
    
    /**
     * Get season
     *
     * @return \Kmc\Bundle\KmcBundle\Entity\Season
     */
    public function getSeason()
    {
    	return $this->season;
    }
    
    /**
     * Set price
     *
     * @param \Kmc\Bundle\KmcBundle\Entity\Price $price
     * @return Price
     */
    public function setPrice(\Kmc\Bundle\KmcBundle\Entity\Price $price = null)
    {
    	$this->price = $price;
    	return $this;
    }
    
    
    /**
     * Get price
     *
     * @return \Kmc\Bundle\KmcBundle\Entity\Price
     */
    public function getPrice()
    {
    	return $this->price;
    }
}
