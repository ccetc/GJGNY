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
    private static $typeChoices = array(
        'presentation' => 'presentation',
        'tabling' => 'tabling',
        'media' => 'media',
    );

    public static function getTypeChoices()
    {
        return self::$typeChoices;
    }

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
    * @var string $type
    *
    * @ORM\Column(name="type", type="string", length=255, nullable="true")
    */
    private $type;
    /**
    * @var string $typeOther
    *
    * @ORM\Column(name="typeOther", type="string", length=255, nullable="true")
    */
    private $typeOther;

    /**
    * @var string $organization
    *
    * @ORM\Column(name="organization", type="string", length=255, nullable="true")
    */
    private $organization;
    /**
    * @var string $email
    *
    * @ORM\Column(name="email", type="string", length=255, nullable="true")
    */
    private $email;
    /**
    * @var string $phone
    *
    * @ORM\Column(name="phone", type="string", length=255, nullable="true")
    */
    private $phone;
    /**
    * @var string $address
    *
    * @ORM\Column(name="address", type="string", length=255, nullable="true")
    */
    private $address;
    /**
    * @var string $city
    *
    * @ORM\Column(name="city", type="string", length=255, nullable="true")
    */
    private $city;
    /**
    * @var string $zip
    *
    * @ORM\Column(name="zip", type="string", length=255, nullable="true")
    */
    private $zip;
    /**
    * @var string $staff
    *
    * @ORM\Column(name="staff", type="string", length=255, nullable="true")
    */
    private $staff;
    /**
    * @var string $prepTime
    *
    * @ORM\Column(name="prepTime", type="string", length=255, nullable="true")
    */
    private $prepTime;
    /**
    * @var string $eventTime
    *
    * @ORM\Column(name="eventTime", type="string", length=255, nullable="true")
    */
    private $eventTime;
    /**
    * @var string $hadPersonalConversationWith
    *
    * @ORM\Column(name="hadPersonalConversationWith", type="string", length=255, nullable="true")
    */
    private $hadPersonalConversationWith;
    /**
    * @var string $totalAttendance
    *
    * @ORM\Column(name="totalAttendance", type="integer", nullable="true")
    */
    private $totalAttendance;    
    /**
    * @var string $totalLeads
    *
    * @ORM\Column(name="totalLeads", type="integer", nullable="true")
    */
    private $totalLeads;    
    /**
    * @var string $totalAppliedAtEvent
    *
    * @ORM\Column(name="totalAppliedAtEvent", type="integer", nullable="true")
    */
    private $totalAppliedAtEvent;    
    /**
    * @var string $totalScheduledAppointment
    *
    * @ORM\Column(name="totalScheduledAppointment", type="integer", nullable="true")
    */
    private $totalScheduledAppointment;
    /**
    * @var string $notes
    *
    * @ORM\Column(name="notes", type="text", nullable="true")
    */
    private $notes;       
    
    
    
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
    
    /** @ORM\OneToMany(targetEntity="PortalSettings", mappedBy="notificationProgram", cascade={"persist", "remove"}) */
    protected $portalPrograms;
    
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
     * @param \Application\Sonata\UserBundle\Entity\User $enteredBy
     */
    public function setEnteredBy(\Application\Sonata\UserBundle\Entity\User $enteredBy)
    {
        $this->enteredBy = $enteredBy;
    }

    /**
     * Get enteredBy
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getEnteredBy()
    {
        return $this->enteredBy;
    }

    /**
     * Set lastUpdatedBy
     *
     * @param Application\Sonata\UserBundle\Entity\User $lastUpdatedBy
     */
    public function setLastUpdatedBy(\Application\Sonata\UserBundle\Entity\User $lastUpdatedBy)
    {
        $this->lastUpdatedBy = $lastUpdatedBy;
    }

    /**
     * Get lastUpdatedBy
     *
     * @return Application\Sonata\UserBundle\Entity\User 
     */
    public function getLastUpdatedBy()
    {
        return $this->lastUpdatedBy;
    }

    /**
     * Add portalPrograms
     *
     * @param GJGNY\DataToolBundle\Entity\PortalSettings $portalPrograms
     */
    public function addPortalSettings(\GJGNY\DataToolBundle\Entity\PortalSettings $portalPrograms)
    {
        $this->portalPrograms[] = $portalPrograms;
    }

    /**
     * Get portalPrograms
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPortalPrograms()
    {
        return $this->portalPrograms;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set organization
     *
     * @param string $organization
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
    }

    /**
     * Get organization
     *
     * @return string 
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Set address
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
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
     * Set zip
     *
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set staff
     *
     * @param string $staff
     */
    public function setStaff($staff)
    {
        $this->staff = $staff;
    }

    /**
     * Get staff
     *
     * @return string 
     */
    public function getStaff()
    {
        return $this->staff;
    }

    /**
     * Set prepTime
     *
     * @param string $prepTime
     */
    public function setPrepTime($prepTime)
    {
        $this->prepTime = $prepTime;
    }

    /**
     * Get prepTime
     *
     * @return string 
     */
    public function getPrepTime()
    {
        return $this->prepTime;
    }

    /**
     * Set eventTime
     *
     * @param string $eventTime
     */
    public function setEventTime($eventTime)
    {
        $this->eventTime = $eventTime;
    }

    /**
     * Get eventTime
     *
     * @return string 
     */
    public function getEventTime()
    {
        return $this->eventTime;
    }

    /**
     * Set hadPersonalConversationWith
     *
     * @param string $hadPersonalConversationWith
     */
    public function setHadPersonalConversationWith($hadPersonalConversationWith)
    {
        $this->hadPersonalConversationWith = $hadPersonalConversationWith;
    }

    /**
     * Get hadPersonalConversationWith
     *
     * @return string 
     */
    public function getHadPersonalConversationWith()
    {
        return $this->hadPersonalConversationWith;
    }

    /**
     * Set totalAttendance
     *
     * @param integer $totalAttendance
     */
    public function setTotalAttendance($totalAttendance)
    {
        $this->totalAttendance = $totalAttendance;
    }

    /**
     * Get totalAttendance
     *
     * @return integer 
     */
    public function getTotalAttendance()
    {
        return $this->totalAttendance;
    }

    /**
     * Set totalLeads
     *
     * @param integer $totalLeads
     */
    public function setTotalLeads($totalLeads)
    {
        $this->totalLeads = $totalLeads;
    }

    /**
     * Get totalLeads
     *
     * @return integer 
     */
    public function getTotalLeads()
    {
        return $this->totalLeads;
    }

    /**
     * Set totalAppliedAtEvent
     *
     * @param integer $totalAppliedAtEvent
     */
    public function setTotalAppliedAtEvent($totalAppliedAtEvent)
    {
        $this->totalAppliedAtEvent = $totalAppliedAtEvent;
    }

    /**
     * Get totalAppliedAtEvent
     *
     * @return integer 
     */
    public function getTotalAppliedAtEvent()
    {
        return $this->totalAppliedAtEvent;
    }

    /**
     * Set totalScheduledAppointment
     *
     * @param integer $totalScheduledAppointment
     */
    public function setTotalScheduledAppointment($totalScheduledAppointment)
    {
        $this->totalScheduledAppointment = $totalScheduledAppointment;
    }

    /**
     * Get totalScheduledAppointment
     *
     * @return integer 
     */
    public function getTotalScheduledAppointment()
    {
        return $this->totalScheduledAppointment;
    }

    /**
     * Set notes
     *
     * @param text $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Get notes
     *
     * @return text 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set typeOther
     *
     * @param string $typeOther
     */
    public function setTypeOther($typeOther)
    {
        $this->typeOther = $typeOther;
    }

    /**
     * Get typeOther
     *
     * @return string 
     */
    public function getTypeOther()
    {
        return $this->typeOther;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
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