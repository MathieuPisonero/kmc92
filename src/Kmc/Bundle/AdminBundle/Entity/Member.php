<?php

namespace Kmc\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Menber
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kmc\Bundle\AdminBundle\Entity\Repository\MemberRepository")
 */
class Member
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
     * @var integer
     *
     * @ORM\Column(name="civility", type="smallint")
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
     * @ORM\Column(name="major", type="string", length=255)
     */
    private $major;

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
     * @ORM\Column(name="practiceyear", type="string", length=255)
     */
    private $practiceyear;

    /**
     * @ORM\Column(name="praticelevel", type="string", length=255)
     */
    private $praticelevel;

     /**
     * @ORM\ManyToOne(targetEntity="\Kmc\Bundle\KmcBundle\Entity\Club", inversedBy="members")
     * @ORM\JoinColumn(name="club", referencedColumnName="id")
     */
    protected $club;

    /**
     * @ORM\OneToMany(targetEntity="\Kmc\Bundle\KmcBundle\Entity\InformationSubscription", mappedBy="member", cascade={"persist"} )
     * @ORM\JoinColumn(name="informations", referencedColumnName="id")
     **/
    protected $informations;

    /**
     * @ORM\OneToMany(targetEntity="MemberSeason", mappedBy="member", cascade={"persist"} )
     * @ORM\JoinColumn(name="seasons", referencedColumnName="id")
     **/
    protected $seasons;
    
    public function __construct() {
    	$this->seasons = new ArrayCollection();
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
     * Set lastname
     *
     * @param string $lastname
     * @return Menber
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
     * @return Menber
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
     * @return Menber
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
     * @return Menber
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
     * @return Menber
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
     * @return Menber
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
     * @return Menber
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
     * @return Menber
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
     * Set city
     *
     * @param string $city
     * @return Menber
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
     * Set major
     *
     * @param string $major
     * @return Menber
     */
    public function setMajor($major)
    {
        $this->major = $major;

        return $this;
    }

    /**
     * Get major
     *
     * @return string 
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * Set responsablefirstname
     *
     * @param string $responsablefirstname
     * @return Menber
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
     * @return Menber
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
     * Set practiceyear
     *
     * @param string $practiceyear
     * @return Menber
     */
    public function setPracticeyear($practiceyear)
    {
        $this->practiceyear = $practiceyear;

        return $this;
    }

    /**
     * Get practiceyear
     *
     * @return string 
     */
    public function getPracticeyear()
    {
        return $this->practiceyear;
    }

    /**
     * Set praticelevel
     *
     * @param string $praticelevel
     * @return Menber
     */
    public function setPraticelevel($praticelevel)
    {
        $this->praticelevel = $praticelevel;

        return $this;
    }

    /**
     * Get praticelevel
     *
     * @return string 
     */
    public function getPraticelevel()
    {
        return $this->praticelevel;
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
     * Set informations
     *
     * @param string $informations
     * @return Menber
     */
    public function setInformations($informations)
    {
        $this->informations = $informations;

        return $this;
    }

    /**
     * Get informations
     *
     * @return string 
     */
    public function getInformations()
    {
        return $this->informations;
    }
    
    
    /**
     * Add seasons
     *
     * @param \Kmc\Bundle\KmcBundle\Entity\MemberSeason $seasons
     * @return MemberSeason
     */
    public function addSeason(\Kmc\Bundle\AdminBundle\Entity\MemberSeason $seasons)
    {
    	$this->seasons[] = $seasons;
    	$seasons->setMember($this);
    	return $this;
    }
    
    /**
     * Remove seasons
     *
     * @param \Kmc\Bundle\AdminBundle\Entity\MemberSeason $seasons
     */
    public function removeSeason(\Kmc\Bundle\AdminBundle\Entity\MemberSeason $seasons)
    {
    	$this->seasons->removeElement($seasons);
    }
    
    /**
     * Get seasons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeasons()
    {
    	return $this->seasons;
    }
    
    public function findSeasonById($id)
    {
     	 foreach ($this->seasons as $season)
    	 {
    	 	if($season->getId() == $id)
    	 	{
    	 		return $season;
    	 	}
    	 }
    	 return false;
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
