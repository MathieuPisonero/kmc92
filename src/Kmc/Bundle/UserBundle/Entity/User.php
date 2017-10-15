<?php

namespace Kmc\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="Kmc\Bundle\UserBundle\Entity\Repository\UserRepository")
 */
class User extends BaseUser
{
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
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
	 * @ORM\Column(name="phone", type="string", length=255)
	 */
	private $phone;
	
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
}