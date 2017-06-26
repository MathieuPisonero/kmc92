<?php

namespace Kmc\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StageSubscription
 *
 * @ORM\Table(name="stagesubscription")
 * @ORM\Entity
 */
class StageSubscription
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
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    

    /**
     * @var integer
     *
     * @ORM\Column(name="civility", type="smallint")
     */
    private $civility;
    
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
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date")
     */
    private $birthdate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="minor", type="boolean")
     */
    private $minor;

    /**
     * @var string
     *
     * @ORM\Column(name="responsablefirstname", type="string", length=255, nullable=true)
     */
    private $responsablefirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="responsablelastname", type="string", length=255, nullable=true)
     */
    private $responsablelastname;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Kmc\Bundle\AdminBundle\Entity\Member")
     **/
    private $member;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Kmc\Bundle\AdminBundle\Entity\Stage")
     **/
    private $stage;

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
     * Set civility
     *
     * @param integer $civility
     * @return Menber
     */
    public function setCivility($civility)
    {
    	$this->civility = $civility;
    
    	return $this;
    }
    
    /**
     * Get civility
     *
     * @return integer
     */
    public function getCivility()
    {
    	return $this->civility;
    }
    
    /**
     * Set firstname
     *
     * @param string $firstname
     * @return stageSubscription
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
     * @return stageSubscription
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
     * Set email
     *
     * @param string $email
     * @return stageSubscription
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return stageSubscription
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return stageSubscription
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set minor
     *
     * @param boolean $minor
     * @return stageSubscription
     */
    public function setMinor($minor)
    {
        $this->minor = $minor;

        return $this;
    }

    /**
     * Get minor
     *
     * @return boolean 
     */
    public function getMinor()
    {
        return $this->minor;
    }

    /**
     * Set responsablefirstname
     *
     * @param string $responsablefirstname
     * @return stageSubscription
     */
    public function setResponsablefirstname($responsablefirstname)
    {
        $this->responsablefirstname = $responsablefirstname;

        return $this;
    }

    /**
     * Get responsablefirstname
     *
     * @return string 
     */
    public function getResponsablefirstname()
    {
        return $this->responsablefirstname;
    }

    /**
     * Set responsablelastname
     *
     * @param string $responsablelastname
     * @return stageSubscription
     */
    public function setResponsablelastname($responsablelastname)
    {
        $this->responsablelastname = $responsablelastname;

        return $this;
    }

    /**
     * Get responsablelastname
     *
     * @return string 
     */
    public function getResponsablelastname()
    {
        return $this->responsablelastname;
    }
    
    /**
     * Set member
     *
     * @param \Kmc\Bundle\AdminBundle\Entity\Member $member
     * @return Member
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
     * Set stage
     *
     * @param \Kmc\Bundle\AdminBundle\Entity\Stage $stage
     * @return Stage
     */
    public function setStage(\Kmc\Bundle\AdminBundle\Entity\Stage $stage = null)
    {
    	$this->stage = $stage;
    
    	return $this;
    }
    
    
    /**
     * Get stage
     *
     * @return \Kmc\Bundle\AdminBundle\Entity\Stage
     */
    public function getStage()
    {
    	return $this->stage;
    }
    
    public function getAge()
    {
    	$timestamp =  $this->getBirthdate()->getTimestamp();
    	$date = date("Y-m-d", $timestamp);
    	$birth = new \DateTime($date);
    	$now = new \DateTime('now');
    	$interval = $birth->diff($now);
    	return($interval->y);
    
    }
}
