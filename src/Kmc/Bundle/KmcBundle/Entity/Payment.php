<?php

namespace Kmc\Bundle\KmcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="payment")
 * @ORM\Entity
 */
class Payment
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
     * @var integer
     *
     * @ORM\Column(name="numberpayment", type="integer")
     */
    private $numberpayment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="bankcheck", type="boolean")
     */
    private $bankcheck;




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
     * @return Payment
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
     * Set bankcheck
     *
     * @param boolean $numberpayment
     * @return Payment
     */
    public function setNumberpayment($numberpayment)
    {
        $this->numberpayment = $numberpayment;

        return $this;
    }

    /**
     * Get numberpayment
     *
     * @return string
     */
    public function getNumberpayment()
    {
        return $this->numberpayment;
    }

    /**
     * Set bankcheck
     *
     * @param boolean $bankcheck
     * @return Payment
     */
    public function setBankcheck($bankcheck)
    {
        $this->bankcheck = $bankcheck;

        return $this;
    }

    /**
     * Get bankcheck
     *
     * @return boolean
     */
    public function getBankcheck()
    {
        return $this->bankcheck;
    }

}
