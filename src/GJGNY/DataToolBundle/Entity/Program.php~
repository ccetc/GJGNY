<?php

namespace GJGNY\DataToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GJGNY\DataToolBundle\Entity\Program
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GJGNY\DataToolBundle\Entity\ProgramRepository")
 */
class Program
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
     * @var date $date
     *
     * @ORM\Column(name="date", type="date", nullable="true")
     */
    private $date;
    
    /**
    * @var string $dataCounty
    *
    * @ORM\Column(name="dataCounty", type="string", length=255, nullable="true")
    */
    private $dataCounty;


    /** @ORM\OneToMany(targetEntity="Lead", mappedBy="Program") */
    protected $Leads;

    /** @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="ProgramsEntered")
    *  @ORM\JoinColumn(name="enteredBy_id", referencedColumnName="id", onDelete="SET NULL") 
    */
    protected $enteredBy;
    /**
    * @var date $datetimeEntered
    *
    * @ORM\Column(name="datetimeEntered", type="datetime", nullable="true")
    */
    private $datetimeEntered;

    /** @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="ProgramsUpdated")
    *  @ORM\JoinColumn(name="lastUpdatedBy_id", referencedColumnName="id", onDelete="SET NULL") 
    */
    protected $lastUpdatedBy;
    /**
    * @var date $datetimeLastUpdated
    *
    * @ORM\Column(name="datetimeLastUpdated", type="datetime", nullable="true")
    */
    private $datetimeLastUpdated;
    
    public function __toString()
    {
        $string = $this->name;
        
        return $string;
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

    /**
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date 
     */
    public function getDate()
    {
        return $this->date;
    }
    public function __construct()
    {
        $this->Leads = new \Doctrine\Common\Collections\ArrayCollection();
        
        $this->date = new \DateTime();        
    }
    
    /**
     * Add Leads
     *
     * @param GJGNY\DataToolBundle\Entity\Lead $leads
     */
    public function addLead(\GJGNY\DataToolBundle\Entity\Lead $leads)
    {
        $this->Leads[] = $leads;
    }

    /**
     * Get Leads
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLeads()
    {
        return $this->Leads;
    }

    /**
     * Set dataCounty
     *
     * @param string $dataCounty
     */
    public function setDataCounty($dataCounty)
    {
        $this->dataCounty = $dataCounty;
    }

    /**
     * Get dataCounty
     *
     * @return string 
     */
    public function getDataCounty()
    {
        return $this->dataCounty;
    }

    /**
     * Set datetimeEntered
     *
     * @param datetime $datetimeEntered
     */
    public function setDatetimeEntered($datetimeEntered)
    {
        $this->datetimeEntered = $datetimeEntered;
    }

    /**
     * Get datetimeEntered
     *
     * @return datetime 
     */
    public function getDatetimeEntered()
    {
        return $this->datetimeEntered;
    }

    /**
     * Set datetimeLastUpdated
     *
     * @param datetime $datetimeLastUpdated
     */
    public function setDatetimeLastUpdated($datetimeLastUpdated)
    {
        $this->datetimeLastUpdated = $datetimeLastUpdated;
    }

    /**
     * Get datetimeLastUpdated
     *
     * @return datetime 
     */
    public function getDatetimeLastUpdated()
    {
        return $this->datetimeLastUpdated;
    }

    /**
     * Set enteredBy
     *
     * @param GJGNY\DataToolBundle\Entity\User $enteredBy
     */
    public function setEnteredBy(\GJGNY\DataToolBundle\Entity\User $enteredBy)
    {
        $this->enteredBy = $enteredBy;
    }

    /**
     * Get enteredBy
     *
     * @return GJGNY\DataToolBundle\Entity\User 
     */
    public function getEnteredBy()
    {
        return $this->enteredBy;
    }

    /**
     * Set lastUpdatedBy
     *
     * @param GJGNY\DataToolBundle\Entity\User $lastUpdatedBy
     */
    public function setLastUpdatedBy(\GJGNY\DataToolBundle\Entity\User $lastUpdatedBy)
    {
        $this->lastUpdatedBy = $lastUpdatedBy;
    }

    /**
     * Get lastUpdatedBy
     *
     * @return GJGNY\DataToolBundle\Entity\User 
     */
    public function getLastUpdatedBy()
    {
        return $this->lastUpdatedBy;
    }
}