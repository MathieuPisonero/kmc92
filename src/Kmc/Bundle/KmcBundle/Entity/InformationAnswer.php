<?php

namespace Kmc\Bundle\KmcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kmc\Bundle\KmcBundle\Entity\Information_question;

/**
 * InformationAnswer
 *
 * @ORM\Table(name="informationanswer")
 * @ORM\Entity
 */
class InformationAnswer
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
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;
    
    /**
     * @var string
     *
     * @ORM\Column(name="custom", type="boolean", length=1)
     */
    private $custom;

    /**
     * @ORM\ManyToOne(targetEntity="InformationQuestion", inversedBy="qqch")
     * @ORM\JoinColumn(name="informationQuestion", referencedColumnName="id")
     */
    private $informationQuestion;




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
     * Set text
     *
     * @param string $text
     * @return InformationAnswer
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Price
     */
    public function setActive($active)
    {
    	$this->active = $active;
    
    	return $this;
    }
    
    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
    	return $this->active;
    }
    
    /**
     * Set informationQuestion
     *
     * @param \Kmc\Bundle\KmcBundle\Entity\InformationQuestion $informationQuestion
     * @return InformationAnswer
     */
    public function setInformationQuestion(\Kmc\Bundle\KmcBundle\Entity\InformationQuestion $informationQuestion = null)
    {
        $this->informationQuestion = $informationQuestion;

        return $this;
    }

    /**
     * Get information_question
     *
     * @return \Kmc\Bundle\KmcBundle\Entity\InformationQuestion
     */
    public function getInformationQuestion()
    {
        return $this->informationQuestion;
    }

    /**
     * Set custom
     *
     * @param boolean $custom
     * @return InformationAnswer
     */
    public function setCustom($custom)
    {
        $this->custom = $custom;

        return $this;
    }

    /**
     * Get custom
     *
     * @return boolean 
     */
    public function getCustom()
    {
        return $this->custom;
    }
}
