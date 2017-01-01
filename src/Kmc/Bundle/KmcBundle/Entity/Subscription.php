<?php

namespace Kmc\Bundle\KmcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Subscription
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Subscription
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
     * @ORM\Column(name="civility", type="string")
     */
    private $civility;
    
    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

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
     * @var string
     *
     * @ORM\Column(name="job", type="string", length=255)
     */
    private $job;

    /**
     * @var string
     *
     * @ORM\Column(name="birthdate", type="date")
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string", length=255)
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="major", type="boolean", length=1, nullable=true)
     */
    private $major;
    
	/**
    * @var boolean
    *
    * @ORM\Column(name="isconvert", type="boolean",options={"default":0})
    */
    private $isconvert;

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
     * @var string
     *
     * @ORM\Column(name="practiceyear", type="integer")
     */
    private $practiceyear;

    /**
     * @var string
     *
     * @ORM\Column(name="practicelevel", type="string", length=255)
     */
    private $practicelevel;

    /**
     * @ORM\ManyToOne(targetEntity="Club", inversedBy="members")
     * @ORM\JoinColumn(name="club", referencedColumnName="id")
     */
    protected $club;

    /**
     * @ORM\OneToMany(targetEntity="InformationSubscription", mappedBy="member", cascade={"persist"} )
     * @ORM\JoinColumn(name="informations", referencedColumnName="id")
     **/
    protected $informations;

    /**
     * @ORM\ManyToOne(targetEntity="Payment")
     * @ORM\JoinColumn(name="payment_id", referencedColumnName="id")
     */
    protected $payment;

    /**
     * @ORM\ManyToOne(targetEntity="Price")
     * @ORM\JoinColumn(name="price_id", referencedColumnName="id")
     */
    protected $price;
    
    /**
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="members")
     * @ORM\JoinColumn(name="season", referencedColumnName="id")
     */
    protected $season;
    

    public function __construct() {
        $this->informations = new ArrayCollection();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="licence", type="string")
     */
    private $licence;

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
     * @param string $civility
     * @return Subcription
     */
    public function setCivility($civility)
    {
    	$this->civility = $civility;
    
    	return $this;
    }
    
    /**
     * Get civility
     *
     * @return string
     */
    public function getCivility()
    {
    	return $this->civility;
    }
    
    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Subcription
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
     * Set firstname
     *
     * @param string $firstname
     * @return Subcription
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
     * Set email
     *
     * @param string $email
     * @return Subcription
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
     * @return Subcription
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
     * Set job
     *
     * @param string $job
     * @return Subcription
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set birthdate
     *
     * @param string $birthdate
     * @return Subcription
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return string 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set adress
     *
     * @param string $adress
     * @return Subcription
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string 
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return Subcription
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string 
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set club
     *
     * @param \Kmc\Bundle\KmcBundle\Entity\Club $club
     * @return Subcription
     */
    public function setClub(\Kmc\Bundle\KmcBundle\Entity\Club $club = null)
    {
        $this->club = $club;
        return $this;
    }

    /**
     * Get club
     *
     * @return \Kmc\Bundle\KmcBundle\Entity\Club
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * Add informations
     *
     * @param \Kmc\Bundle\KmcBundle\Entity\InformationSubscription $informations
     * @return Subcription
     */
    public function addInformation(\Kmc\Bundle\KmcBundle\Entity\InformationSubscription $informations)
    {
        $this->informations[] = $informations;
        $informations->setSubscription($this);

        return $this;
    }

    /**
     * Remove informations
     *
     * @param \Kmc\Bundle\KmcBundle\Entity\InformationSubscription $informations
     */
    public function removeInformation(\Kmc\Bundle\KmcBundle\Entity\InformationSubscription $informations)
    {
        $this->informations->removeElement($informations);
    }

    /**
     * Get informations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInformations()
    {
        return $this->informations;
    }

    /**
     * Set major
     *
     * @param boolean $major
     * @return Subcription
     */
    public function setMajor($major)
    {
        $this->major = $major;

        return $this;
    }

    /**
     * Get major
     *
     * @return boolean 
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * Set isconvert
     *
     * @param boolean $isconvert
     * @return Subcription
     */
    public function setIsconvert($isconvert)
    {
    	$this->isconvert = $isconvert;
    
    	return $this;
    }
    
    /**
     * Get isconvert
     *
     * @return boolean
     */
    public function getIsconvert()
    {
    	return $this->isconvert;
    }
    /**
     * Set responsablefirstname
     *
     * @param string $responsablefirstname
     * @return Subcription
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
     * @return Subcription
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
     * Set city
     *
     * @param string $city
     * @return Subscription
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
     * Set practiceyear
     *
     * @param integer $practiceyear
     * @return Subscription
     */
    public function setPracticeyear($practiceyear)
    {
        $this->practiceyear = $practiceyear;

        return $this;
    }

    /**
     * Get practiceyear
     *
     * @return integer 
     */
    public function getPracticeyear()
    {
        return $this->practiceyear;
    }

    /**
     * Set practicelevel
     *
     * @param string $practicelevel
     * @return Subscription
     */
    public function setPracticelevel($practicelevel)
    {
        $this->practicelevel = $practicelevel;

        return $this;
    }

    /**
     * Get practicelevel
     *
     * @return string 
     */
    public function getPracticelevel()
    {
        return $this->practicelevel;
    }

    /**
     * Set payment
     *
     * @param \Kmc\Bundle\KmcBundle\Entity\Payment $payment
     * @return Subscription
     */
    public function setPayment(\Kmc\Bundle\KmcBundle\Entity\Payment $payment = null)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return \Kmc\Bundle\KmcBundle\Entity\Payment 
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set price
     *
     * @param \Kmc\Bundle\KmcBundle\Entity\Price $price
     * @return Subscription
     */
    public function setPrice(\Kmc\Bundle\KmcBundle\Entity\Price $price = null)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get payment
     *
     * @return \Kmc\Bundle\KmcBundle\Entity\Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set licence
     *
     * @param string $licence
     * @return Subscription
     */
    public function setLicence($licence)
    {
        $this->licence = $licence;

        return $this;
    }

    /**
     * Get practicelevel
     *
     * @return string
     */
    public function getLicence()
    {
        return $this->licence;
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
    
    /**
     * Set season
     *
     * @param \Kmc\Bundle\KmcBundle\Entity\Season $season
     * @return Subcription
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
}
