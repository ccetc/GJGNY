<?php

namespace GJGNY\DataToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GJGNY\DataToolBundle\Entity\PortalSettings
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PortalSettings
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
     * @ORM\ManyToMany(targetEntity="County", inversedBy="portalsServedBy")
     * @ORM\JoinTable(name="PortalSettingsToCounties")
     */
    private $countiesServed;

    /** @ORM\ManyToOne(targetEntity="County", inversedBy="portalsOwned") */
    protected $countyOwnedBy;

    /** @ORM\ManyToOne(targetEntity="Portal", inversedBy="portalSettings") */
    protected $portal;

    /** @ORM\ManyToOne(targetEntity="Program", inversedBy="portalPrograms") */
    protected $notificationProgram;

    /**
     * @ORM\ManyToMany(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="notificationPortals")
     * @ORM\JoinTable(name="PortalSettingsToUsers")
     */
    private $notificationUsers;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    
    public function __construct()
    {
        $this->countiesServed = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->portal.' - '.$this->countyOwnedBy;
    }
    
    /**
     * Add countiesServed
     *
     * @param GJGNY\DataToolBundle\Entity\County $countiesServed
     */
    public function addCounty(\GJGNY\DataToolBundle\Entity\County $countiesServed)
    {
        $this->countiesServed[] = $countiesServed;
    }

    /**
     * Get countiesServed
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCountiesServed()
    {
        return $this->countiesServed;
    }

    /**
     * Set countyOwnedBy
     *
     * @param GJGNY\DataToolBundle\Entity\County $countyOwnedBy
     */
    public function setCountyOwnedBy(\GJGNY\DataToolBundle\Entity\County $countyOwnedBy)
    {
        $this->countyOwnedBy = $countyOwnedBy;
    }

    /**
     * Get countyOwnedBy
     *
     * @return GJGNY\DataToolBundle\Entity\County 
     */
    public function getCountyOwnedBy()
    {
        return $this->countyOwnedBy;
    }

    /**
     * Set portal
     *
     * @param GJGNY\DataToolBundle\Entity\Portal $portal
     */
    public function setPortal(\GJGNY\DataToolBundle\Entity\Portal $portal)
    {
        $this->portal = $portal;
    }

    /**
     * Get portal
     *
     * @return GJGNY\DataToolBundle\Entity\Portal 
     */
    public function getPortal()
    {
        return $this->portal;
    }

    /**
     * Set notificationProgram
     *
     * @param GJGNY\DataToolBundle\Entity\Program $notificationProgram
     */
    public function setNotificationProgram(\GJGNY\DataToolBundle\Entity\Program $notificationProgram)
    {
        $this->notificationProgram = $notificationProgram;
    }

    /**
     * Get notificationProgram
     *
     * @return GJGNY\DataToolBundle\Entity\Program 
     */
    public function getNotificationProgram()
    {
        return $this->notificationProgram;
    }

    /**
     * Add notificationUsers
     *
     * @param Application\Sonata\UserBundle\Entity\User $notificationUsers
     */
    public function addUser(\Application\Sonata\UserBundle\Entity\User $notificationUsers)
    {
        $this->notificationUsers[] = $notificationUsers;
    }

    /**
     * Get notificationUsers
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getNotificationUsers()
    {
        return $this->notificationUsers;
    }
    /**
     * Set notificationUsers
     *
     */
    public function setNotificationUsers($notifcationUsers)
    {
        $this->notificationUsers = $notifcationUsers;
    }
}