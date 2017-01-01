<?php

namespace Kmc\Bundle\KmcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * InformationQuestion
 *
 * @ORM\Table(name="informationquestion")
 * @ORM\Entity
 */
class InformationQuestion
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
     * @ORM\OneToMany(targetEntity="InformationAnswer", mappedBy="informationQuestion" )
     * @ORM\JoinColumn(name="answers", referencedColumnName="id")
     **/
    private $answers;

    public function __construct() {
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set text
     *
     * @param string $text
     * @return InformationQuestion
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
     * Add answers
     *
     * @param \Kmc\Bundle\KmcBundle\Entity\InformationAnswer $answers
     * @return InformationQuestion
     */
    public function addAnswer(\Kmc\Bundle\KmcBundle\Entity\InformationAnswer $answers)
    {
        $this->answers[] = $answers;

        return $this;
    }

    /**
     * Remove answers
     *
     * @param \Kmc\Bundle\KmcBundle\Entity\InformationAnswer $answers
     */
    public function removeAnswer(\Kmc\Bundle\KmcBundle\Entity\InformationAnswer $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnswers()
    {
        return $this->answers;
    }
}
