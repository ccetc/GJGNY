<?php

namespace GJGNY\DataToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GJGNY\DataToolBundle\Entity\County
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class County
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\ManyToMany(targetEntity="PortalSettings", mappedBy="countiesServed")
     */
    private $portalsServedBy;
    
    /** @ORM\OneToMany(targetEntity="PortalSettings", mappedBy="countyOwnedBy", cascade={"persist", "remove"}) */
    protected $portalsOwned;

    /** @ORM\OneToMany(targetEntity="Lead", mappedBy="countyEntity", cascade={"persist", "remove"}) */
    protected $leads;    
    
    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function __construct()
    {
        $this->portalsServedBy = new \Doctrine\Common\Collections\ArrayCollection();
    $this->portalsOwned = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add portalsServedBy
     *
     * @param GJGNY\DataToolBundle\Entity\PortalSettings $portalsServedBy
     */
    public function addPortalSettings(\GJGNY\DataToolBundle\Entity\PortalSettings $portalsServedBy)
    {
        $this->portalsServedBy[] = $portalsServedBy;
    }

    /**
     * Get portalsServedBy
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPortalsServedBy()
    {
        return $this->portalsServedBy;
    }

    /**
     * Get portalsOwned
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPortalsOwned()
    {
        return $this->portalsOwned;
    }

    /**
     * Add leads
     *
     * @param GJGNY\DataToolBundle\Entity\Lead $leads
     */
    public function addLead(\GJGNY\DataToolBundle\Entity\Lead $leads)
    {
        $this->leads[] = $leads;
    }

    /**
     * Get leads
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLeads()
    {
        return $this->leads;
    }
}