<?php

namespace GJGNY\DataToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GJGNY\DataToolBundle\Entity\LeadEvent
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GJGNY\DataToolBundle\Entity\LeadEventRepository")
 */
class LeadEvent
{
  /** @ORM\ManyToOne(targetEntity="Lead", inversedBy="LeadEvents") */
  protected $Lead;
  
  /** @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="LeadEventsEntered")
   *  @ORM\JoinColumn(name="enteredBy_id", referencedColumnName="id", onDelete="SET NULL") 
   */
  protected $enteredBy;
  /**
   * @var date $datetimeEntered
   *
   * @ORM\Column(name="datetimeEntered", type="datetime", nullable="true")
   */
  private $datetimeEntered;
  
  /** @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="LeadEventsUpdated")
   *  @ORM\JoinColumn(name="lastUpdatedBy_id", referencedColumnName="id", onDelete="SET NULL") 
   */
  protected $lastUpdatedBy;
  /**
   * @var date $datetimeLastUpdated
   *
   * @ORM\Column(name="datetimeLastUpdated", type="datetime", nullable="true")
   */
  private $datetimeLastUpdated;
  
  
  
  private static $eventTypeChoices = array(
      'generic' => 'generic',
      'phone call' => 'phone call',
      'in person' => 'in person',
      'e-mail' => 'e-mail',
      'lead acquisition' => 'lead acquisition',
      'training referral' => 'training referral',
      'job referral' => 'job referral'
  );
  
  private static $callStatusChoices = array (
      'answered and spoke' => 'answered and spoke',
      'answered and declined' => 'answered and declined',
      'left message' => 'left message',
      'no answer, no machine' => 'no answer, no machine',
      'wrong number / missing number' => 'wrong number / missing number',
  );
  
  public static function getEventTypeChoices()
  {
    return self::$eventTypeChoices;
  }
  
  public static function getCallStatusChoices()
  {
    return self::$callStatusChoices;
  }

  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
  
  // GENERAL FIELDS ============================================================
  // ===========================================================================
  /**
   * @var string $eventType
   *
   * @ORM\Column(name="eventType", type="string", length=255, nullable="true")
   */
  private $eventType;
  /**
   * @var string $eventTypeOther
   *
   * @ORM\Column(name="eventTypeOther", type="string", length=255, nullable="true")
   */
  private $eventTypeOther;
  /**
   * @var date $date
   *
   * @ORM\Column(name="date", type="datetime", nullable="true")
   */
  private $date;
  /**
   * @var string $description
   *
   * @ORM\Column(name="description", type="string", length=255, nullable="true")
   */
  private $description;
  /**
   * @var string $notes
   *
   * @ORM\Column(name="notes", type="text", nullable="true")
   */
  private $notes;

  
  // PHONE CALL FIELDS =========================================================
  // ===========================================================================
  /**
   * @var string $contactPerson
   *
   * @ORM\Column(name="contactPerson", type="string", length=255, nullable="true")
   */
  private $contactPerson;
  /**
   * @var string $callStatus
   *
   * @ORM\Column(name="callStatus", type="string", length=255, nullable="true")
   */
  private $callStatus;
  /**
   * @var text $WhatWasDiscussed
   *
   * @ORM\Column(name="WhatWasDiscussed", type="text", nullable="true")
   */
  private $WhatWasDiscussed;
  /**
   * @var string $actionsTaken
   *
   * @ORM\Column(name="actionsTaken", type="string", length=255, nullable="true")
   */
  private $actionsTaken;
  /**
   * @var text $callNotes
   *
   * @ORM\Column(name="callNotes", type="text", nullable="true")
   */
  private $callNotes;
  /**
   * @var smallint $canWeCallBack
   *
   * @ORM\Column(name="canWeCallBack", type="boolean")
   */
  private $canWeCallBack;
  
   /**
   * @var text $FollowUpItems
   *
   * @ORM\Column(name="FollowUpItems", type="text", nullable="true")
   */
  private $FollowUpItems;
  
  // Referrals
  /**
   * @var text $institution
   *
   * @ORM\Column(name="institution", type="string", length=255, nullable="true")
   */
  private $institution;
  /**
   * @var text $program
   *
   * @ORM\Column(name="program", type="string", length=255, nullable="true")
   */
  private $program;
  /**
   * @var date $dateOfTrainingReferral
   *
   * @ORM\Column(name="dateOfTrainingReferral", type="date", nullable="true")
   */
  private $dateOfTrainingReferral;
  /**
   * @var date $dateOfCompletion
   *
   * @ORM\Column(name="dateOfCompletion", type="date", nullable="true")
   */
  private $dateOfCompletion;
  /**
   * @var text $business
   *
   * @ORM\Column(name="business", type="string", length=255, nullable="true")
   */
  private $business;
  /**
   * @var date $dateOfJobReferral
   *
   * @ORM\Column(name="dateOfJobReferral", type="date", nullable="true")
   */
  private $dateOfJobReferral;
  
  // LUT PHONE SURVEY FIELDS ===================================================
  // ===========================================================================
  /**
   * @var smallint $lutBulb
   *
   * @ORM\Column(name="lutBulb", type="boolean")
   */
  private $lutBulb;
  /**
   * @var smallint $lutBulbReplace
   *
   * @ORM\Column(name="lutBulbReplace", type="boolean")
   */
  private $lutBulbReplace;
  /**
   * @var smallint $lutLookAtMaterials
   *
   * @ORM\Column(name="lutLookAtMaterials", type="boolean")
   */
  private $lutLookAtMaterials;
  /**
   * @var smallint $lutMaterialsUseful
   *
   * @ORM\Column(name="lutMaterialsUseful", type="boolean")
   */
  private $lutMaterialsUseful;
  /**
   * @var string $lutStepsTake
   *
   * @ORM\Column(name="lutStepsTaken", type="string", length=255, nullable="true")
   */
  private $lutStepsTaken;
  /**
   * @var string $lutStepsTakeGeneral
   *
   * @ORM\Column(name="lutStepsTakenGeneral", type="string", length=255, nullable="true")
   */
  private $lutStepsTakenGeneral;  
  /**
   * @var string $lutRentOrOwn
   *
   * @ORM\Column(name="lutRentOrOwn", type="string", length=255, nullable="true")
   */
  private $lutRentOrOwn;
  /**
   * @var string $lutBarriers
   *
   * @ORM\Column(name="lutBarriers", type="string", length=255, nullable="true")
   */
  private $lutBarriers;
  /**
   * @var smallint $lutAssessment
   *
   * @ORM\Column(name="lutAssessment", type="boolean")
   */
  private $lutAssessment;
  /**
   * @var string $lutSupport
   *
   * @ORM\Column(name="lutSupport", type="string", length=255, nullable="true")
   */
  private $lutSupport;
  /**
   * @var smallint $lutNewsletter
   *
   * @ORM\Column(name="lutNewsletter", type="boolean")
   */
  private $lutNewsletter;
  /**
   * @var string $lutQuestions
   *
   * @ORM\Column(name="lutQuestions", type="string", length=255, nullable="true")
   */
  private $lutQuestions;
  /**
   * @var smallint $lutCouponMailed
   *
   * @ORM\Column(name="lutCouponMailed", type="boolean")
   */
  private $lutCouponMailed;
  /**
   * @var string $lutCouponType
   *
   * @ORM\Column(name="lutCouponType", type="string", length=255, nullable="true")
   */
  private $lutCouponType;
    
  public function __construct()
  {
    $this->date = new \DateTime();
    $this->canWeCallBack = false;
    $this->lutBulb = false;
    $this->lutAssessment = false;
    $this->lutBulbReplace = false;
    $this->lutCouponMailed = false;
    $this->lutLookAtMaterials = false;
    $this->lutMaterialsUseful = false;
    $this->lutNewsletter = false;
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
   * Set WhatWasDiscussed
   *
   * @param text $whatWasDiscussed
   */
  public function setWhatWasDiscussed($whatWasDiscussed)
  {
    $this->WhatWasDiscussed = $whatWasDiscussed;
  }

  /**
   * Get WhatWasDiscussed
   *
   * @return text 
   */
  public function getWhatWasDiscussed()
  {
    return $this->WhatWasDiscussed;
  }

  /**
   * Set FollowUpItems
   *
   * @param text $followUpItems
   */
  public function setFollowUpItems($followUpItems)
  {
    $this->FollowUpItems = $followUpItems;
  }

  /**
   * Get FollowUpItems
   *
   * @return text 
   */
  public function getFollowUpItems()
  {
    return $this->FollowUpItems;
  }

    /**
     * Set lead
     *
     * @param GJGNY\DataToolBundle\Entity\Lead $lead
     */
    public function setLead(\GJGNY\DataToolBundle\Entity\Lead $Lead)
    {
        $this->Lead = $Lead;
    }

    /**
     * Get lead
     *
     * @return GJGNY\DataToolBundle\Entity\Lead 
     */
    public function getLead()
    {
        return $this->Lead;
    }
    
    public function __toString()
    {
      // only return a string if this LeadEvent has been saved
      if(isset($this->datetimeEntered))
      {
        if(isset($this->eventType)) $eventType = $this->eventType;
        else if(isset($this->eventTypeOther)) $eventType = $this->eventTypeOther;
        
        $val = $this->Lead;
        if(isset($eventType)) $val .= ' - '.$eventType;
        else $val .= ' - event';
        
        if(isset($this->date)) $val .= ' - '.date_format($this->date, 'F j, Y');
        
        return $val;
      }
      else return '';
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

    /**
     * Set eventType
     *
     * @param string $eventType
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
    }

    /**
     * Get eventType
     *
     * @return string 
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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
     * Set callStatus
     *
     * @param string $callStatus
     */
    public function setCallStatus($callStatus)
    {
        $this->callStatus = $callStatus;
    }

    /**
     * Get callStatus
     *
     * @return string 
     */
    public function getCallStatus()
    {
        return $this->callStatus;
    }

    /**
     * Set callNotes
     *
     * @param text $callNotes
     */
    public function setCallNotes($callNotes)
    {
        $this->callNotes = $callNotes;
    }

    /**
     * Get callNotes
     *
     * @return text 
     */
    public function getCallNotes()
    {
        return $this->callNotes;
    }

    /**
     * Set canWeCallBack
     *
     * @param boolean $canWeCallBack
     */
    public function setCanWeCallBack($canWeCallBack)
    {
        $this->canWeCallBack = $canWeCallBack;
    }

    /**
     * Get canWeCallBack
     *
     * @return boolean 
     */
    public function getCanWeCallBack()
    {
        return $this->canWeCallBack;
    }

    /**
     * Set lutBulb
     *
     * @param boolean $lutBulb
     */
    public function setLutBulb($lutBulb)
    {
        $this->lutBulb = $lutBulb;
    }

    /**
     * Get lutBulb
     *
     * @return boolean 
     */
    public function getLutBulb()
    {
        return $this->lutBulb;
    }

    /**
     * Set lutLookAtMaterials
     *
     * @param boolean $lutLookAtMaterials
     */
    public function setLutLookAtMaterials($lutLookAtMaterials)
    {
        $this->lutLookAtMaterials = $lutLookAtMaterials;
    }

    /**
     * Get lutLookAtMaterials
     *
     * @return boolean 
     */
    public function getLutLookAtMaterials()
    {
        return $this->lutLookAtMaterials;
    }

    /**
     * Set lutMaterialsUseful
     *
     * @param boolean $lutMaterialsUseful
     */
    public function setLutMaterialsUseful($lutMaterialsUseful)
    {
        $this->lutMaterialsUseful = $lutMaterialsUseful;
    }

    /**
     * Get lutMaterialsUseful
     *
     * @return boolean 
     */
    public function getLutMaterialsUseful()
    {
        return $this->lutMaterialsUseful;
    }

    /**
     * Set lutStepsTaken
     *
     * @param string $lutStepsTaken
     */
    public function setLutStepsTaken($lutStepsTaken)
    {
        $this->lutStepsTaken = $lutStepsTaken;
    }

    /**
     * Get lutStepsTaken
     *
     * @return string 
     */
    public function getLutStepsTaken()
    {
        return $this->lutStepsTaken;
    }

    /**
     * Set lutStepsTakenGeneral
     *
     * @param string $lutStepsTakenGeneral
     */
    public function setLutStepsTakenGeneral($lutStepsTakenGeneral)
    {
        $this->lutStepsTakenGeneral = $lutStepsTakenGeneral;
    }

    /**
     * Get lutStepsTakenGeneral
     *
     * @return string 
     */
    public function getLutStepsTakenGeneral()
    {
        return $this->lutStepsTakenGeneral;
    }

    /**
     * Set lutBarriers
     *
     * @param string $lutBarriers
     */
    public function setLutBarriers($lutBarriers)
    {
        $this->lutBarriers = $lutBarriers;
    }

    /**
     * Get lutBarriers
     *
     * @return string 
     */
    public function getLutBarriers()
    {
        return $this->lutBarriers;
    }

    /**
     * Set lutAssessment
     *
     * @param boolean $lutAssessment
     */
    public function setLutAssessment($lutAssessment)
    {
        $this->lutAssessment = $lutAssessment;
    }

    /**
     * Get lutAssessment
     *
     * @return boolean 
     */
    public function getLutAssessment()
    {
        return $this->lutAssessment;
    }

    /**
     * Set lutSupport
     *
     * @param string $lutSupport
     */
    public function setLutSupport($lutSupport)
    {
        $this->lutSupport = $lutSupport;
    }

    /**
     * Get lutSupport
     *
     * @return string 
     */
    public function getLutSupport()
    {
        return $this->lutSupport;
    }

    /**
     * Set lutNewsletter
     *
     * @param boolean $lutNewsletter
     */
    public function setLutNewsletter($lutNewsletter)
    {
        $this->lutNewsletter = $lutNewsletter;
    }

    /**
     * Get lutNewsletter
     *
     * @return boolean 
     */
    public function getLutNewsletter()
    {
        return $this->lutNewsletter;
    }

    /**
     * Set lutQuestions
     *
     * @param string $lutQuestions
     */
    public function setLutQuestions($lutQuestions)
    {
        $this->lutQuestions = $lutQuestions;
    }

    /**
     * Get lutQuestions
     *
     * @return string 
     */
    public function getLutQuestions()
    {
        return $this->lutQuestions;
    }

    /**
     * Set lutCouponMailed
     *
     * @param boolean $lutCouponMailed
     */
    public function setLutCouponMailed($lutCouponMailed)
    {
        $this->lutCouponMailed = $lutCouponMailed;
    }

    /**
     * Get lutCouponMailed
     *
     * @return boolean 
     */
    public function getLutCouponMailed()
    {
        return $this->lutCouponMailed;
    }

    /**
     * Set lutCouponType
     *
     * @param string $lutCouponType
     */
    public function setLutCouponType($lutCouponType)
    {
        $this->lutCouponType = $lutCouponType;
    }

    /**
     * Get lutCouponType
     *
     * @return string 
     */
    public function getLutCouponType()
    {
        return $this->lutCouponType;
    }

    /**
     * Set lutBulbReplace
     *
     * @param boolean $lutBulbReplace
     */
    public function setLutBulbReplace($lutBulbReplace)
    {
        $this->lutBulbReplace = $lutBulbReplace;
    }

    /**
     * Get lutBulbReplace
     *
     * @return boolean 
     */
    public function getLutBulbReplace()
    {
        return $this->lutBulbReplace;
    }

    /**
     * Set lutRentOrOwn
     *
     * @param string $lutRentOrOwn
     */
    public function setLutRentOrOwn($lutRentOrOwn)
    {
        $this->lutRentOrOwn = $lutRentOrOwn;
    }

    /**
     * Get lutRentOrOwn
     *
     * @return string 
     */
    public function getLutRentOrOwn()
    {
        return $this->lutRentOrOwn;
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
    

    /**
     * Set actionsTaken
     *
     * @param string $actionsTaken
     */
    public function setActionsTaken($actionsTaken)
    {
        $this->actionsTaken = $actionsTaken;
    }

    /**
     * Get actionsTaken
     *
     * @return string 
     */
    public function getActionsTaken()
    {
        return $this->actionsTaken;
    }

    /**
     * Set eventTypeOther
     *
     * @param string $eventTypeOther
     */
    public function setEventTypeOther($eventTypeOther)
    {
        $this->eventTypeOther = $eventTypeOther;
    }

    /**
     * Get eventTypeOther
     *
     * @return string 
     */
    public function getEventTypeOther()
    {
        return $this->eventTypeOther;
    }

    /**
     * Set contactPerson
     *
     * @param string $contactPerson
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;
    }

    /**
     * Get contactPerson
     *
     * @return string 
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     * Set institution
     *
     * @param string $institution
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;
    }

    /**
     * Get institution
     *
     * @return string 
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Set program
     *
     * @param string $program
     */
    public function setProgram($program)
    {
        $this->program = $program;
    }

    /**
     * Get program
     *
     * @return string 
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * Set dateOfTrainingReferral
     *
     * @param date $dateOfTrainingReferral
     */
    public function setDateOfTrainingReferral($dateOfTrainingReferral)
    {
        $this->dateOfTrainingReferral = $dateOfTrainingReferral;
    }

    /**
     * Get dateOfTrainingReferral
     *
     * @return date 
     */
    public function getDateOfTrainingReferral()
    {
        return $this->dateOfTrainingReferral;
    }

    /**
     * Set dateOfCompletion
     *
     * @param dateOfCompletion $dateOfCompletion
     */
    public function setDateOfCompletion($dateOfCompletion)
    {
        $this->dateOfCompletion = $dateOfCompletion;
    }

    /**
     * Get dateOfCompletion
     *
     * @return dateOfCompletion 
     */
    public function getDateOfCompletion()
    {
        return $this->dateOfCompletion;
    }

    /**
     * Set business
     *
     * @param string $business
     */
    public function setBusiness($business)
    {
        $this->business = $business;
    }

    /**
     * Get business
     *
     * @return string 
     */
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * Set dateOfJobReferral
     *
     * @param date $dateOfJobReferral
     */
    public function setDateOfJobReferral($dateOfJobReferral)
    {
        $this->dateOfJobReferral = $dateOfJobReferral;
    }

    /**
     * Get dateOfJobReferral
     *
     * @return date 
     */
    public function getDateOfJobReferral()
    {
        return $this->dateOfJobReferral;
    }
}