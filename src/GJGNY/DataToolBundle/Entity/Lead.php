<?php

namespace GJGNY\DataToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GJGNY\DataToolBundle\Entity\Lead
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GJGNY\DataToolBundle\Entity\LeadRepository")
 */
class Lead
  {
  /** @ORM\ManyToOne(targetEntity="User", inversedBy="LeadsEntered")
   *  @ORM\JoinColumn(name="enteredBy_id", referencedColumnName="id", onDelete="SET NULL") 
   */
  protected $enteredBy;
  /**
   * @var date $datetimeEntered
   *
   * @ORM\Column(name="datetimeEntered", type="datetime", nullable="true")
   */
  private $datetimeEntered;
  
  /** @ORM\ManyToOne(targetEntity="User", inversedBy="LeadsUpdated")
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
    $s = $this->FirstName.' ';
    if(isset($this->middleInitial)) {
        $s .= $this->middleInitial;
        if(!strstr($this->middleInitial, '.')) $s .= '. ';
        else $s .= ' ';
    }
    $s .= $this->LastName;
    return $s;
  }
  
  protected static $stateChoices = array(
      'AL'=>"Alabama",'AK'=>"Alaska",'AZ'=>"Arizona",'AR'=>"Arkansas",'CA'=>"California",'CO'=>"Colorado",'CT'=>"Connecticut",'DE'=>"Delaware",'DC'=>"District Of Columbia", 'FL'=>"Florida",'GA'=>"Georgia",'HI'=>"Hawaii",'ID'=>"Idaho",'IL'=>"Illinois",'IN'=>"Indiana",'IA'=>"Iowa",'KS'=>"Kansas",'KY'=>"Kentucky",'LA'=>"Louisiana",'ME'=>"Maine",'MD'=>"Maryland",'MA'=>"Massachusetts",'MI'=>"Michigan",'MN'=>"Minnesota",'MS'=>"Mississippi",'MO'=>"Missouri",'MT'=>"Montana",'NE'=>"Nebraska",'NV'=>"Nevada",'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",'OK'=>"Oklahoma",'OR'=>"Oregon",'PA'=>"Pennsylvania",'RI'=>"Rhode Island",'SC'=>"South Carolina",'SD'=>"South Dakota",'TN'=>"Tennessee",'TX'=>"Texas",'UT'=>"Utah",'VT'=>"Vermont",'VA'=>"Virginia",'WA'=>"Washington",'WV'=>"West Virginia",'WI'=>"Wisconsin",'WY'=>"Wyoming"
  );


  protected static $stepChoices = array (
      'step1' => '1. Low cost / no cost',
      'step2' => '2. Energy Assessment',
      'step2aInterested' => '2a. interested in assessment',
      'step2bSubmitted' => '2b. GJGNY app submitted',
      'step2cScheduled' => '2c. assessment scheduled',
      'step2dCompleted' => '2d. assessment complete',        
      'step3' => '3. Whole house upgrade',
      'step4' => '4. Upgrade Appliances',
      'step5' => '5. Renewable energy',
  );
  
  protected static $campaignChoices = array(
      'campaignChoiceTalkingToNeighbors' => 'talk to neighbors',
      'campaignChoiceFormEnergyTeam' => 'form an energy team',
      'campaignChoiceAppearInVideo' => 'appear in testimonial video',
      'campaignChoiceShareExperience' => 'share experience with others',
  );
  protected static $motivationChoices = array(
      'motivationChoiceComfort' => 'comfort',
      'motivationChoiceMoney' => 'saving money',
      'motivationChoiceIndoorAir' => 'indoor air quality',
      'motivationChoiceEnvironment' => 'environment',
      'motivationChoiceOther' => 'other',
  );
  protected static $newsletterChoices = array(
      'newsletterChoiceEnergyTips' => 'energy saving tips',
      'newsletterChoiceSavings' => 'energy saving programs',
      'newsletterChoiceEvents' => 'upcoming events',
  );
  protected static $SourceOfLeadChoices = array(
      'Contractor' => 'Contractor',
      'Door to door canvas' => 'Door to door canvas',
      'E-mail' => 'E-mail',
      'Energy Corps.' => 'Energy Corps.',
      'Energy Team' => 'Energy Team',
      'Neighbor / Friends' => 'Neighbor / Friends',
      'Newspaper Article' => 'Newspaper Article',
      'Phone' => 'Phone',
      'Presentation' => 'Presentation',
      'Tabling' => 'Tabling',
      'Website' => 'Website',
  );
  protected static $incomeRangeChoices = array(
      '<= 200% AMI' => '<= 200% AMI',
      '<= 250% AMI' => '<= 250% AMI',
      '<= 300% AMI' => '<= 300% AMI',
      '<= 350% AMI' => '<= 350% AMI',
      '<= 400% AMI' => '<= 400% AMI',
  );
  protected static $GJGNYReferenceChoices = array(
      'Constituency Based Organization' => 'Constituency Based Organization',
      'Contractor' => 'Contractor',
      'NYSERDA' => 'NYSERDA',
      'Neighbor/ friend' => 'Neighbor/ friend',
      'Municipality' => 'Municipality',
      'Energy $mart Coordinator' => 'Energy $mart Coordinator',
      'Newspaper' => 'Newspaper',
      'Circular/flyer' => 'Circular/flyer',
      'Home show' => 'Home show',
      'Verbal' => 'Verbal',
      'Radio' => 'Radio',
      'Television' => 'Television',
      'Internet' => 'Internet',
  );
  protected static $buildingTypeChoices = array(
      'single family' => 'single family',
      '2 unit' => '2 unit',
      '3 unit' => '3 unit',
      '4 unit' => '4 unit',
  );
  protected static $otherFuelSupplierTypeChoices = array(
      'oil' => 'oil',
      'propane' => 'propane',
  );
  protected static $howAssessmentFinancedChoices = array(
      'out-of-pocket' => 'out-of-pocket',
      'AHP' => 'AHP',
      'GJGNY Loan' => 'GJGNY Loan'
  );
  
  protected static $leadTypeChoices = array (
      'energy upgrade' => 'energy upgrade',
      'outreach' => 'outreach',
  );
  
  protected static $leadStatusChoices = array (
      'need to call' => 'need to call',
      'awaiting follow up' => 'awaiting follow up',
      'not interested' => 'not interested',
      'already done' => 'already done',
      'had previous upgrade' => 'had previous upgrade',
      'process complete, got upgrade' => 'process complete, got upgrade',
  );
  
  public static function getLeadStatusChoices()
  {
      return self::$leadStatusChoices;
  }
  
  public static function getLeadTypeChoices()
  {
      return self::$leadTypeChoices;
  }

  public static function getStateChoices()
  {
    return self::$stateChoices;
  }
  public static function getMotivationChoices()
  {
    return self::$motivationChoices;
  }

  public static function getSourceOfLeadChoices()
  {
    return self::$SourceOfLeadChoices;
  }

  public static function getIncomeRangeChoices()
  {
    return self::$incomeRangeChoices;
  }

  public static function getGJGNYReferenceChoices()
  {
    return self::$GJGNYReferenceChoices;
  }

  public static function getBuildingTypeChoices()
  {
    return self::$buildingTypeChoices;
  }

  public static function getOtherFuelSupplierTypeChoices()
  {
    return self::$otherFuelSupplierTypeChoices;
  }

  public static function getHowAssessmentFinancedChoices()
  {
    return self::$howAssessmentFinancedChoices;
  }

  public static function getNewsletterChoices()
  {
    return self::$newsletterChoices;
  }
  
  public static function getCampaignChoices()
  {
    return self::$campaignChoices;
  }
  
  public static function getStepChoices()
  {
    return self::$stepChoices;
  }

  /** @ORM\OneToMany(targetEntity="LeadEvent", mappedBy="Lead", cascade={"persist", "remove"}) */
  protected $LeadEvents;
  
  /**
   * @var string $dataCounty
   *
   * @ORM\Column(name="dataCounty", type="string", length=255, nullable="true")
   */
  private $dataCounty;
  
  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
  /**
   * @var string $FirstName
   *
   * @ORM\Column(name="FirstName", type="string", length=255, nullable="true")
   */
  private $FirstName;
  /**
   * @var string $middleInitial
   *
   * @ORM\Column(name="middleInitial", type="string", length=255, nullable="true")
   */
  private $middleInitial;
  /**
   * @var string $LastName
   *
   * @ORM\Column(name="LastName", type="string", length=255, nullable="true")
   */
  private $LastName;
  /**
   * @var string $Address
   *
   * @ORM\Column(name="Address", type="string", length=255, nullable="true")
   */
  private $Address;
  /**
   * @var string $City
   *
   * @ORM\Column(name="City", type="string", length=255, nullable="true")
   */
  private $City;
  /**
   * @var string $State
   *
   * @ORM\Column(name="State", type="string", length=2, nullable="true")
   */
  private $State;
  /**
   * @var integer $Zip
   *
   * @ORM\Column(name="Zip", type="string", length=5, nullable="true")
   */
  private $Zip;
  /**
   * @var string $Town
   *
   * @ORM\Column(name="Town", type="string", length=255, nullable="true")
   */
  private $Town;
  /**
   * @var string $county
   *
   * @ORM\Column(name="county", type="string", length=255, nullable="true")
   */
  private $county;
  /**
   * @var string $phone
   *
   * @ORM\Column(name="phone", type="string", length=100, nullable="true")
   */
  private $phone;
   /**
   * @var string $primaryPhoneType
   *
   * @ORM\Column(name="primaryPhoneType", type="string", length=255, nullable="true")
   */
  private $primaryPhoneType;
  /**
   * @var string $secondaryPhone
   *
   * @ORM\Column(name="secondaryPhone", type="string", length=100, nullable="true")
   */
  private $secondaryPhone;
  /**
   * @var string $secondaryPhoneType
   *
   * @ORM\Column(name="secondaryPhoneType", type="string", length=255, nullable="true")
   */
  private $secondaryPhoneType;
  /**
   * @var string $personalEmail
   *
   * @ORM\Column(name="personalEmail", type="string", length=255, nullable="true")
   */
  private $personalEmail;
  /**
   * @var string $workEmail
   *
   * @ORM\Column(name="workEmail", type="string", length=255, nullable="true")
   */
  private $workEmail;
  /**
   * @var string $SourceOfLead
   *
   * @ORM\Column(name="SourceOfLead", type="string", length=255, nullable="true")
   */
  private $SourceOfLead;
  /**
   * @var string $ProgramSource
   *
   * @ORM\Column(name="ProgramSource", type="string", length=255, nullable="true")
   */
  private $ProgramSource;
  /**
   * @var string $DateOfLead
   *
   * @ORM\Column(name="DateOfLead", type="date", nullable="true")
   */
  private $DateOfLead;
  
  /**
   * @var string $leadType
   *
   * @ORM\Column(name="leadType", type="string", length=255, nullable="true")
   */
  private $leadType;
  
  /**
   * @var string $leadReferral
   *
   * @ORM\Column(name="leadReferral", type="string", length=255, nullable="true")
   */
  private $leadReferral;
    
  /**
   * @var string $leadStatus
   *
   * @ORM\Column(name="leadStatus", type="string", length=255, nullable="true")
   */
  private $leadStatus;
  
  /**
   * @var date $DateOfNextFollowup
   *
   * @ORM\Column(name="DateOfNextFollowup", type="date", nullable="true")
   */
  private $DateOfNextFollowup;
  
  
  /**
   * @var string $organization
   *
   * @ORM\Column(name="organization", type="string", length=255, nullable="true")
   */
  private $organization;
   /**
   * @var string $orgTitle
   *
   * @ORM\Column(name="orgTitle", type="string", length=255, nullable="true")
   */
  private $orgTitle;
  /**
   * @var string $orgAddress
   *
   * @ORM\Column(name="orgAddress", type="string", length=255, nullable="true")
   */
  private $orgAddress;
  /**
   * @var string $orgCity
   *
   * @ORM\Column(name="orgCity", type="string", length=255, nullable="true")
   */
  private $orgCity;
  /**
   * @var string $orgState
   *
   * @ORM\Column(name="orgState", type="string", length=2, nullable="true")
   */
  private $orgState;
  /**
   * @var string $orgZip
   *
   * @ORM\Column(name="orgZip", type="string", length=5, nullable="true")
   */
  private $orgZip;
  /**
   * @var string $orgCounty
   *
   * @ORM\Column(name="orgCounty", type="string", length=255, nullable="true")
   */
  private $orgCounty; 
  
// PATH STEPS===================================================================
// =============================================================================  
  /**
   * @var smallint $step1
   *
   * @ORM\Column(name="step1", type="boolean")
   */
  private $step1;
  /**
   * @var smallint $step2
   *
   * @ORM\Column(name="step2", type="boolean")
   */
  private $step2;
  /**
   * @var smallint $step3
   *
   * @ORM\Column(name="step3", type="boolean")
   */
  private $step3;
  /**
   * @var smallint $step4
   *
   * @ORM\Column(name="step4", type="boolean")
   */
  private $step4;
  /**
   * @var smallint $step5
   *
   * @ORM\Column(name="step5", type="boolean")
   */
  private $step5;
  /**
   * @var string $step1aActionsTaken
   *
   * @ORM\Column(name="step1aActionsTaken", type="string", length=255, nullable="true")
   */
  private $step1aActionsTaken;
  /**
   * @var smallint $step2aInterested
   *
   * @ORM\Column(name="step2aInterested", type="boolean")
   */
  private $step2aInterested;
  /**
   * @var smallint $step2bSubmitted
   *
   * @ORM\Column(name="step2bSubmitted", type="boolean")
   */
  private $step2bSubmitted;
  /**
   * @var smallint $step2cScheduled
   *
   * @ORM\Column(name="step2cScheduled", type="boolean")
   */
  private $step2cScheduled;
  /**
   * @var smallint $step2dCompleted
   *
   * @ORM\Column(name="step2dCompleted", type="boolean")
   */
  private $step2dCompleted;
  /**
   * @var string $step3aContractor
   *
   * @ORM\Column(name="step3aContractor", type="string", length=255, nullable="true")
   */
  private $step3aContractor;
  /**
   * @var string $step3bWorkDone
   *
   * @ORM\Column(name="step3bWorkDone", type="string", length=255, nullable="true")
   */
  private $step3bWorkDone;
  /**
   * @var string $step3cHowFinanced
   *
   * @ORM\Column(name="step3cHowFinanced", type="string", length=255, nullable="true")
   */
  private $step3cHowFinanced;
// OTHER INFORMATION============================================================
// =============================================================================  
  /**
   * @var string $CommunityGroupsConnectedTo
   *
   * @ORM\Column(name="CommunityGroupsConnectedTo", type="string", length=255, nullable="true")
   */
  private $CommunityGroupsConnectedTo;
  /**
   * @var string $barriers
   *
   * @ORM\Column(name="barriers", type="string", length=255, nullable="true")
   */
  private $barriers;
  /**
   * @var smallint $interestedInVisit
   *
   * @ORM\Column(name="interestedInVisit", type="boolean")
   */
  private $interestedInVisit;
  /**
   * @var smallint $newsletterChoiceEnergyTips
   *
   * @ORM\Column(name="newsletterChoiceEnergyTips", type="boolean")
   */
  private $newsletterChoiceEnergyTips;
  /**
   * @var smallint $newsletterChoiceEvents
   *
   * @ORM\Column(name="newsletterChoiceEvents", type="boolean")
   */
  private $newsletterChoiceEvents;
  /**
   * @var smallint $newsletterChoiceSavings
   *
   * @ORM\Column(name="newsletterChoiceSavings", type="boolean")
   */
  private $newsletterChoiceSavings;
  /**
   * @var smallint $campaignChoiceTalkingToNeighbors
   *
   * @ORM\Column(name="campaignChoiceTalkingToNeighbors", type="boolean")
   */
  private $campaignChoiceTalkingToNeighbors;
  /**
   * @var smallint $campaignChoiceFormEnergyTeam
   *
   * @ORM\Column(name="campaignChoiceFormEnergyTeam", type="boolean")
   */
  private $campaignChoiceFormEnergyTeam;
  /**
   * @var smallint $campaignChoiceAppearInVideo
   *
   * @ORM\Column(name="campaignChoiceAppearInVideo", type="boolean")
   */
  private $campaignChoiceAppearInVideo;
  /**
   * @var smallint $campaignChoiceShareExperience
   *
   * @ORM\Column(name="campaignChoiceShareExperience", type="boolean")
   */
  private $campaignChoiceShareExperience;
  /**
   * @var smallint $motivationChoiceComfort
   *
   * @ORM\Column(name="motivationChoiceComfort", type="boolean")
   */
  private $motivationChoiceComfort;
  /**
   * @var smallint $motivationChoiceMoney
   *
   * @ORM\Column(name="motivationChoiceMoney", type="boolean")
   */
  private $motivationChoiceMoney;
  /**
   * @var smallint $motivationChoiceIndoorAir
   *
   * @ORM\Column(name="motivationChoiceIndoorAir", type="boolean")
   */
  private $motivationChoiceIndoorAir;
  /**
   * @var smallint $motivationChoiceEnvironment
   *
   * @ORM\Column(name="motivationChoiceEnvironment", type="boolean")
   */
  private $motivationChoiceEnvironment;
  /**
   * @var smallint $motivationChoiceOther
   *
   * @ORM\Column(name="motivationChoiceOther", type="string", length=255, nullable="true")
   */
  private $motivationChoiceOther;
  /**
   * @var string $otherNotes
   *
   * @ORM\Column(name="otherNotes", type="text", nullable="true")
   */
  private $otherNotes;
    /**
   * @var string $website
   *
   * @ORM\Column(name="website", type="string", length=255, nullable="true")
   */
  private $website;
  /**
   * @var smallint $homeowner
   *
   * @ORM\Column(name="homeowner", type="boolean")
   */
  private $homeowner;
  /**
   * @var smallint $renter
   *
   * @ORM\Column(name="renter", type="boolean")
   */
  private $renter;
  /**
   * @var smallint $landlord
   *
   * @ORM\Column(name="landlord", type="boolean")
   */
  private $landlord;
// GJGNY APPLICATION DATA ======================================================
// =============================================================================
  /**
   * @var string $GJGNYReference
   *
   * @ORM\Column(name="GJGNYReference", type="string", length=255, nullable="true")
   */
  private $GJGNYReference;
  /**
   * @var string $GJGNYReferenceOther
   *
   * @ORM\Column(name="GJGNYReferenceOther", type="string", length=255, nullable="true")
   */
  private $GJGNYReferenceOther;
  /**
   * @var smallint $financeChoiceGJGNY
   *
   * @ORM\Column(name="financeChoiceGJGNY", type="boolean")
   */
  private $financeChoiceGJGNY;
  /**
   * @var smallint $financeChoiceHomeEquity
   *
   * @ORM\Column(name="financeChoiceHomeEquity", type="boolean")
   */
  private $financeChoiceHomeEquity;
  /**
   * @var smallint $financeChoicePocket
   *
   * @ORM\Column(name="financeChoicePocket", type="boolean")
   */
  private $financeChoicePocket;
  /**
   * @var smallint $financeChoicePersonal
   *
   * @ORM\Column(name="financeChoicePersonal", type="boolean")
   */
  private $financeChoicePersonal;
  /**
   * @var string $incomeRange
   *
   * @ORM\Column(name="incomeRange", type="string", length=255, nullable="true")
   */
  private $incomeRange;
  /**
   * @var string $buildingType
   *
   * @ORM\Column(name="buildingType", type="text", length=255, nullable="true")
   */
  private $buildingType;
  /**
   * @var string $sqFootage
   *
   * @ORM\Column(name="sqFootage", type="string", length=255, nullable="true")
   */
  private $sqFootage;
  /**
   * @var string $electricUtility
   *
   * @ORM\Column(name="electricUtility", type="string", length=255, nullable="true")
   */
  private $electricUtility;
  /**
   * @var string $electricUtilityAcct
   *
   * @ORM\Column(name="electricUtilityAcct", type="string", length=255, nullable="true")
   */
  private $electricUtilityAcct;
  /**
   * @var string $gasUtility
   *
   * @ORM\Column(name="gasUtility", type="string", length=255, nullable="true")
   */
  private $gasUtility;
  /**
   * @var string $gasUtilityAcct
   *
   * @ORM\Column(name="gasUtilityAcct", type="string", length=255, nullable="true")
   */
  private $gasUtilityAcct;
  /**
   * @var smallint $hasCentralAC
   *
   * @ORM\Column(name="hasCentralAC", type="boolean")
   */
  private $hasCentralAC;
  /**
   * @var string $otherFuelSupplier
   *
   * @ORM\Column(name="otherFuelSupplier", type="string", length=255, nullable="true")
   */
  private $otherFuelSupplier;
  /**
   * @var string $otherFuelSupplierType
   *
   * @ORM\Column(name="otherFuelSupplierType", type="string", length=255, nullable="true")
   */
  private $otherFuelSupplierType;
  /**
   * @var string $otherFuelSupplierTypeOther
   *
   * @ORM\Column(name="otherFuelSupplierTypeOther", type="string", length=255, nullable="true")
   */
  private $otherFuelSupplierTypeOther;
  /**
   * @var string $otherFuelSupplierAcct
   *
   * @ORM\Column(name="otherFuelSupplierAcct", type="string", length=255, nullable="true")
   */
  private $otherFuelSupplierAcct;
 // Broome Fields
  /**
   * @var string $pledge
   *
   * @ORM\Column(name="pledge", type="string", length=255, nullable="true")
   */
  private $pledge;
  /**
   * @var string $BECCTeam
   *
   * @ORM\Column(name="BECCTeam", type="string", length=255, nullable="true")
   */
  private $BECCTeam;
  /**
   * @var string $visitPeriod
   *
   * @ORM\Column(name="visitPeriod", type="string", length=255, nullable="true")
   */
  private $visitPeriod;
  /**
   * @var string $rank
   *
   * @ORM\Column(name="rank", type="string", length=255, nullable="true")
   */
  private $rank;  
  // Tompkins Fields
  /**
   * @var smallint $october2011Raffle
   *
   * @ORM\Column(name="october2011Raffle", type="boolean")
   */
  private $october2011Raffle;
  
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
   * Set FirstName
   *
   * @param string $firstName
   */
  public function setFirstName($firstName)
  {
    $this->FirstName = $firstName;
  }

  /**
   * Get FirstName
   *
   * @return string 
   */
  public function getFirstName()
  {
    return $this->FirstName;
  }

  /**
   * Set LastName
   *
   * @param string $lastName
   */
  public function setLastName($lastName)
  {
    $this->LastName = $lastName;
  }

  /**
   * Get LastName
   *
   * @return string 
   */
  public function getLastName()
  {
    return $this->LastName;
  }

  /**
   * Set Address
   *
   * @param string $address
   */
  public function setAddress($address)
  {
    $this->Address = $address;
  }

  /**
   * Get Address
   *
   * @return string 
   */
  public function getAddress()
  {
    return $this->Address;
  }

  /**
   * Set City
   *
   * @param string $city
   */
  public function setCity($city)
  {
    $this->City = $city;
  }

  /**
   * Get City
   *
   * @return string 
   */
  public function getCity()
  {
    return $this->City;
  }

  /**
   * Set Zip
   *
   * @param integer $zip
   */
  public function setZip($zip)
  {
    $this->Zip = $zip;
  }

  /**
   * Get Zip
   *
   * @return integer 
   */
  public function getZip()
  {
    return $this->Zip;
  }

  /**
   * Set Phone
   *
   * @param string $phone
   */
  public function setPhone($phone)
  {
    $this->phone = $phone;
  }

  /**
   * Get Phone
   *
   * @return string 
   */
  public function getPhone()
  {
    return $this->phone;
  }

  /**
   * Set SourceOfLead
   *
   * @param string $sourceOfLead
   */
  public function setSourceOfLead($sourceOfLead)
  {
    $this->SourceOfLead = $sourceOfLead;
  }

  /**
   * Get SourceOfLead
   *
   * @return string 
   */
  public function getSourceOfLead()
  {
    return $this->SourceOfLead;
  }

  /**
   * Set state
   *
   * @param string $state
   */
  public function setState($state)
  {
    $this->State = $state;
  }

  /**
   * Get state
   *
   * @return string 
   */
  public function getState()
  {
    return $this->State;
  }

  /**
   * Set Town
   *
   * @param string $town
   */
  public function setTown($town)
  {
    $this->Town = $town;
  }

  /**
   * Get Town
   *
   * @return string 
   */
  public function getTown()
  {
    return $this->Town;
  }

  /**
   * Set CommunityGroupsConnectedTo
   *
   * @param string $communityGroupsConnectedTo
   */
  public function setCommunityGroupsConnectedTo($communityGroupsConnectedTo)
  {
    $this->CommunityGroupsConnectedTo = $communityGroupsConnectedTo;
  }

  /**
   * Get CommunityGroupsConnectedTo
   *
   * @return string 
   */
  public function getCommunityGroupsConnectedTo()
  {
    return $this->CommunityGroupsConnectedTo;
  }

  /**
   * Set DateOfLead
   *
   * @param date $dateOfLead
   */
  public function setDateOfLead($dateOfLead)
  {
    $this->DateOfLead = $dateOfLead;
  }

  /**
   * Get DateOfLead
   *
   * @return date 
   */
  public function getDateOfLead()
  {
    return $this->DateOfLead;
  }

  /**
   * Add LeadEvents
   *
   * @param GJGNY\DataToolBundle\Entity\LeadEvent $LeadEvents
   */
  public function addLeadEvents(\GJGNY\DataToolBundle\Entity\LeadEvent $LeadEvents)
  {
    $this->LeadEvents[] = $LeadEvents;
  }

  /**
   * Get LeadEvents
   *
   * @return Doctrine\Common\Collections\Collection 
   */
  public function getLeadEvents()
  {
    return $this->LeadEvents;
  }

  public function __construct()
  {
    $this->LeadEvents = new \Doctrine\Common\Collections\ArrayCollection();
    $this->DateOfLead = new \DateTime();
    $this->DateOfNextFollowup = new \DateTime();
    $this->DateOfNextFollowup->modify('+2 weeks');
  }

  /**
   * Set newsletterChoiceEnergyTips
   *
   * @param boolean $newsletterChoiceEnergyTips
   */
  public function setNewsletterChoiceEnergyTips($newsletterChoiceEnergyTips)
  {
    $this->newsletterChoiceEnergyTips = $newsletterChoiceEnergyTips;
  }

  /**
   * Get newsletterChoiceEnergyTips
   *
   * @return boolean 
   */
  public function getNewsletterChoiceEnergyTips()
  {
    return $this->newsletterChoiceEnergyTips;
  }

  /**
   * Set newsletterChoiceEvents
   *
   * @param boolean $newsletterChoiceEvents
   */
  public function setNewsletterChoiceEvents($newsletterChoiceEvents)
  {
    $this->newsletterChoiceEvents = $newsletterChoiceEvents;
  }

  /**
   * Get newsletterChoiceEvents
   *
   * @return boolean 
   */
  public function getNewsletterChoiceEvents()
  {
    return $this->newsletterChoiceEvents;
  }

  /**
   * Set newsletterChoiceSavings
   *
   * @param boolean $newsletterChoiceSavings
   */
  public function setNewsletterChoiceSavings($newsletterChoiceSavings)
  {
    $this->newsletterChoiceSavings = $newsletterChoiceSavings;
  }

  /**
   * Get newsletterChoiceSavings
   *
   * @return boolean 
   */
  public function getNewsletterChoiceSavings()
  {
    return $this->newsletterChoiceSavings;
  }

  /**
   * Set campaignChoiceTalkingToNeighbors
   *
   * @param boolean $campaignChoiceTalkingToNeighbors
   */
  public function setCampaignChoiceTalkingToNeighbors($campaignChoiceTalkingToNeighbors)
  {
    $this->campaignChoiceTalkingToNeighbors = $campaignChoiceTalkingToNeighbors;
  }

  /**
   * Get campaignChoiceTalkingToNeighbors
   *
   * @return boolean 
   */
  public function getCampaignChoiceTalkingToNeighbors()
  {
    return $this->campaignChoiceTalkingToNeighbors;
  }

  /**
   * Set campaignChoiceFormEnergyTeam
   *
   * @param boolean $campaignChoiceFormEnergyTeam
   */
  public function setCampaignChoiceFormEnergyTeam($campaignChoiceFormEnergyTeam)
  {
    $this->campaignChoiceFormEnergyTeam = $campaignChoiceFormEnergyTeam;
  }

  /**
   * Get campaignChoiceFormEnergyTeam
   *
   * @return boolean 
   */
  public function getCampaignChoiceFormEnergyTeam()
  {
    return $this->campaignChoiceFormEnergyTeam;
  }

  /**
   * Set campaignChoiceAppearInVideo
   *
   * @param boolean $campaignChoiceAppearInVideo
   */
  public function setCampaignChoiceAppearInVideo($campaignChoiceAppearInVideo)
  {
    $this->campaignChoiceAppearInVideo = $campaignChoiceAppearInVideo;
  }

  /**
   * Get campaignChoiceAppearInVideo
   *
   * @return boolean 
   */
  public function getCampaignChoiceAppearInVideo()
  {
    return $this->campaignChoiceAppearInVideo;
  }

  /**
   * Set campaignChoiceShareExperience
   *
   * @param boolean $campaignChoiceShareExperience
   */
  public function setCampaignChoiceShareExperience($campaignChoiceShareExperience)
  {
    $this->campaignChoiceShareExperience = $campaignChoiceShareExperience;
  }

  /**
   * Get campaignChoiceShareExperience
   *
   * @return boolean 
   */
  public function getCampaignChoiceShareExperience()
  {
    return $this->campaignChoiceShareExperience;
  }

  /**
   * Set motivationChoiceComfort
   *
   * @param boolean $motivationChoiceComfort
   */
  public function setMotivationChoiceComfort($motivationChoiceComfort)
  {
    $this->motivationChoiceComfort = $motivationChoiceComfort;
  }

  /**
   * Get motivationChoiceComfort
   *
   * @return boolean 
   */
  public function getMotivationChoiceComfort()
  {
    return $this->motivationChoiceComfort;
  }

  /**
   * Set motivationChoiceMoney
   *
   * @param boolean $motivationChoiceMoney
   */
  public function setMotivationChoiceMoney($motivationChoiceMoney)
  {
    $this->motivationChoiceMoney = $motivationChoiceMoney;
  }

  /**
   * Get motivationChoiceMoney
   *
   * @return boolean 
   */
  public function getMotivationChoiceMoney()
  {
    return $this->motivationChoiceMoney;
  }

  /**
   * Set motivationChoiceIndoorAir
   *
   * @param boolean $motivationChoiceIndoorAir
   */
  public function setMotivationChoiceIndoorAir($motivationChoiceIndoorAir)
  {
    $this->motivationChoiceIndoorAir = $motivationChoiceIndoorAir;
  }

  /**
   * Get motivationChoiceIndoorAir
   *
   * @return boolean 
   */
  public function getMotivationChoiceIndoorAir()
  {
    return $this->motivationChoiceIndoorAir;
  }

  /**
   * Set motivationChoiceEnvironment
   *
   * @param boolean $motivationChoiceEnvironment
   */
  public function setMotivationChoiceEnvironment($motivationChoiceEnvironment)
  {
    $this->motivationChoiceEnvironment = $motivationChoiceEnvironment;
  }

  /**
   * Get motivationChoiceEnvironment
   *
   * @return boolean 
   */
  public function getMotivationChoiceEnvironment()
  {
    return $this->motivationChoiceEnvironment;
  }

  /**
   * Set motivationChoiceOther
   *
   * @param text $motivationChoiceOther
   */
  public function setMotivationChoiceOther($motivationChoiceOther)
  {
    $this->motivationChoiceOther = $motivationChoiceOther;
  }

  /**
   * Get motivationChoiceOther
   *
   * @return text 
   */
  public function getMotivationChoiceOther()
  {
    return $this->motivationChoiceOther;
  }

  /**
   * Set financeChoiceGJGNY
   *
   * @param boolean $financeChoiceGJGNY
   */
  public function setFinanceChoiceGJGNY($financeChoiceGJGNY)
  {
    $this->financeChoiceGJGNY = $financeChoiceGJGNY;
  }

  /**
   * Get financeChoiceGJGNY
   *
   * @return boolean 
   */
  public function getFinanceChoiceGJGNY()
  {
    return $this->financeChoiceGJGNY;
  }

  /**
   * Set financeChoiceHomeEquity
   *
   * @param boolean $financeChoiceHomeEquity
   */
  public function setFinanceChoiceHomeEquity($financeChoiceHomeEquity)
  {
    $this->financeChoiceHomeEquity = $financeChoiceHomeEquity;
  }

  /**
   * Get financeChoiceHomeEquity
   *
   * @return boolean 
   */
  public function getFinanceChoiceHomeEquity()
  {
    return $this->financeChoiceHomeEquity;
  }

  /**
   * Set financeChoicePocket
   *
   * @param boolean $financeChoicePocket
   */
  public function setFinanceChoicePocket($financeChoicePocket)
  {
    $this->financeChoicePocket = $financeChoicePocket;
  }

  /**
   * Get financeChoicePocket
   *
   * @return boolean 
   */
  public function getFinanceChoicePocket()
  {
    return $this->financeChoicePocket;
  }

  /**
   * Set financeChoicePersonal
   *
   * @param boolean $financeChoicePersonal
   */
  public function setFinanceChoicePersonal($financeChoicePersonal)
  {
    $this->financeChoicePersonal = $financeChoicePersonal;
  }

  /**
   * Get financeChoicePersonal
   *
   * @return boolean 
   */
  public function getFinanceChoicePersonal()
  {
    return $this->financeChoicePersonal;
  }

  /**
   * Set incomeChoice200
   *
   * @param boolean $incomeChoice200
   */
  public function setIncomeChoice200($incomeChoice200)
  {
    $this->incomeChoice200 = $incomeChoice200;
  }

  /**
   * Get incomeChoice200
   *
   * @return boolean 
   */
  public function getIncomeChoice200()
  {
    return $this->incomeChoice200;
  }

  /**
   * Set incomeChoice250
   *
   * @param boolean $incomeChoice250
   */
  public function setIncomeChoice250($incomeChoice250)
  {
    $this->incomeChoice250 = $incomeChoice250;
  }

  /**
   * Get incomeChoice250
   *
   * @return boolean 
   */
  public function getIncomeChoice250()
  {
    return $this->incomeChoice250;
  }

  /**
   * Set incomeChoice300
   *
   * @param boolean $incomeChoice300
   */
  public function setIncomeChoice300($incomeChoice300)
  {
    $this->incomeChoice300 = $incomeChoice300;
  }

  /**
   * Get incomeChoice300
   *
   * @return boolean 
   */
  public function getIncomeChoice300()
  {
    return $this->incomeChoice300;
  }

  /**
   * Set incomeChoice350
   *
   * @param boolean $incomeChoice350
   */
  public function setIncomeChoice350($incomeChoice350)
  {
    $this->incomeChoice350 = $incomeChoice350;
  }

  /**
   * Get incomeChoice350
   *
   * @return boolean 
   */
  public function getIncomeChoice350()
  {
    return $this->incomeChoice350;
  }

  /**
   * Set incomeChoice400
   *
   * @param boolean $incomeChoice400
   */
  public function setIncomeChoice400($incomeChoice400)
  {
    $this->incomeChoice400 = $incomeChoice400;
  }

  /**
   * Get incomeChoice400
   *
   * @return boolean 
   */
  public function getIncomeChoice400()
  {
    return $this->incomeChoice400;
  }

  /**
   * Set incomeRange
   *
   * @param string $incomeRange
   */
  public function setIncomeRange($incomeRange)
  {
    $this->incomeRange = $incomeRange;
  }

  /**
   * Get incomeRange
   *
   * @return string 
   */
  public function getIncomeRange()
  {
    return $this->incomeRange;
  }

  /**
   * Set GJGNYReference
   *
   * @param string $gJGNYReference
   */
  public function setGJGNYReference($gJGNYReference)
  {
    $this->GJGNYReference = $gJGNYReference;
  }

  /**
   * Get GJGNYReference
   *
   * @return string 
   */
  public function getGJGNYReference()
  {
    return $this->GJGNYReference;
  }

  /**
   * Set GJGNYReferenceOther
   *
   * @param string $gJGNYReferenceOther
   */
  public function setGJGNYReferenceOther($gJGNYReferenceOther)
  {
    $this->GJGNYReferenceOther = $gJGNYReferenceOther;
  }

  /**
   * Get GJGNYReferenceOther
   *
   * @return string 
   */
  public function getGJGNYReferenceOther()
  {
    return $this->GJGNYReferenceOther;
  }

  /**
   * Set buildingType
   *
   * @param text $buildingType
   */
  public function setBuildingType($buildingType)
  {
    $this->buildingType = $buildingType;
  }

  /**
   * Get buildingType
   *
   * @return text 
   */
  public function getBuildingType()
  {
    return $this->buildingType;
  }

  /**
   * Set sqFootage
   *
   * @param text $sqFootage
   */
  public function setSqFootage($sqFootage)
  {
    $this->sqFootage = $sqFootage;
  }

  /**
   * Get sqFootage
   *
   * @return text 
   */
  public function getSqFootage()
  {
    return $this->sqFootage;
  }

  /**
   * Set electricUtility
   *
   * @param text $electricUtility
   */
  public function setElectricUtility($electricUtility)
  {
    $this->electricUtility = $electricUtility;
  }

  /**
   * Get electricUtility
   *
   * @return text 
   */
  public function getElectricUtility()
  {
    return $this->electricUtility;
  }

  /**
   * Set electricUtilityAcct
   *
   * @param text $electricUtilityAcct
   */
  public function setElectricUtilityAcct($electricUtilityAcct)
  {
    $this->electricUtilityAcct = $electricUtilityAcct;
  }

  /**
   * Get electricUtilityAcct
   *
   * @return text 
   */
  public function getElectricUtilityAcct()
  {
    return $this->electricUtilityAcct;
  }

  /**
   * Set gasUtility
   *
   * @param text $gasUtility
   */
  public function setGasUtility($gasUtility)
  {
    $this->gasUtility = $gasUtility;
  }

  /**
   * Get gasUtility
   *
   * @return text 
   */
  public function getGasUtility()
  {
    return $this->gasUtility;
  }

  /**
   * Set gasUtilityAcct
   *
   * @param text $gasUtilityAcct
   */
  public function setGasUtilityAcct($gasUtilityAcct)
  {
    $this->gasUtilityAcct = $gasUtilityAcct;
  }

  /**
   * Get gasUtilityAcct
   *
   * @return text 
   */
  public function getGasUtilityAcct()
  {
    return $this->gasUtilityAcct;
  }

  /**
   * Set hasCentralAC
   *
   * @param boolean $hasCentralAC
   */
  public function setHasCentralAC($hasCentralAC)
  {
    $this->hasCentralAC = $hasCentralAC;
  }

  /**
   * Get hasCentralAC
   *
   * @return boolean 
   */
  public function getHasCentralAC()
  {
    return $this->hasCentralAC;
  }

  /**
   * Set otherFuelSupplier
   *
   * @param text $otherFuelSupplier
   */
  public function setOtherFuelSupplier($otherFuelSupplier)
  {
    $this->otherFuelSupplier = $otherFuelSupplier;
  }

  /**
   * Get otherFuelSupplier
   *
   * @return text 
   */
  public function getOtherFuelSupplier()
  {
    return $this->otherFuelSupplier;
  }

  /**
   * Set otherFuelSupplierType
   *
   * @param text $otherFuelSupplierType
   */
  public function setOtherFuelSupplierType($otherFuelSupplierType)
  {
    $this->otherFuelSupplierType = $otherFuelSupplierType;
  }

  /**
   * Get otherFuelSupplierType
   *
   * @return text 
   */
  public function getOtherFuelSupplierType()
  {
    return $this->otherFuelSupplierType;
  }

  /**
   * Set otherFuelSupplierTypeOther
   *
   * @param text $otherFuelSupplierTypeOther
   */
  public function setOtherFuelSupplierTypeOther($otherFuelSupplierTypeOther)
  {
    $this->otherFuelSupplierTypeOther = $otherFuelSupplierTypeOther;
  }

  /**
   * Get otherFuelSupplierTypeOther
   *
   * @return text 
   */
  public function getOtherFuelSupplierTypeOther()
  {
    return $this->otherFuelSupplierTypeOther;
  }

  /**
   * Set otherFuelSupplierAcct
   *
   * @param text $otherFuelSupplierAcct
   */
  public function setOtherFuelSupplierAcct($otherFuelSupplierAcct)
  {
    $this->otherFuelSupplierAcct = $otherFuelSupplierAcct;
  }

  /**
   * Get otherFuelSupplierAcct
   *
   * @return text 
   */
  public function getOtherFuelSupplierAcct()
  {
    return $this->otherFuelSupplierAcct;
  }

  /**
   * Set step1
   *
   * @param boolean $step1
   */
  public function setStep1($step1)
  {
    $this->step1 = $step1;
  }

  /**
   * Get step1
   *
   * @return boolean 
   */
  public function getStep1()
  {
    return $this->step1;
  }

  /**
   * Set step2
   *
   * @param boolean $step2
   */
  public function setStep2($step2)
  {
    $this->step2 = $step2;
  }

  /**
   * Get step2
   *
   * @return boolean 
   */
  public function getStep2()
  {
    return $this->step2;
  }

  /**
   * Set step3
   *
   * @param boolean $step3
   */
  public function setStep3($step3)
  {
    $this->step3 = $step3;
  }

  /**
   * Get step3
   *
   * @return boolean 
   */
  public function getStep3()
  {
    return $this->step3;
  }

  /**
   * Set step4
   *
   * @param boolean $step4
   */
  public function setStep4($step4)
  {
    $this->step4 = $step4;
  }

  /**
   * Get step4
   *
   * @return boolean 
   */
  public function getStep4()
  {
    return $this->step4;
  }

  /**
   * Set step5
   *
   * @param boolean $step5
   */
  public function setStep5($step5)
  {
    $this->step5 = $step5;
  }

  /**
   * Get step5
   *
   * @return boolean 
   */
  public function getStep5()
  {
    return $this->step5;
  }

  /**
   * Set step1aActionsTaken
   *
   * @param string $step1aActionsTaken
   */
  public function setStep1aActionsTaken($step1aActionsTaken)
  {
    $this->step1aActionsTaken = $step1aActionsTaken;
  }

  /**
   * Get step1aActionsTaken
   *
   * @return string 
   */
  public function getStep1aActionsTaken()
  {
    return $this->step1aActionsTaken;
  }

  /**
   * Set step2aInterested
   *
   * @param boolean $step2aInterested
   */
  public function setStep2aInterested($step2aInterested)
  {
    $this->step2aInterested = $step2aInterested;
  }

  /**
   * Get step2aInterested
   *
   * @return boolean 
   */
  public function getStep2aInterested()
  {
    return $this->step2aInterested;
  }

  /**
   * Set step2cScheduled
   *
   * @param boolean $step2cScheduled
   */
  public function setStep2cScheduled($step2cScheduled)
  {
    $this->step2cScheduled = $step2cScheduled;
  }

  /**
   * Get step2cScheduled
   *
   * @return boolean 
   */
  public function getStep2cScheduled()
  {
    return $this->step2cScheduled;
  }

  /**
   * Set step3aContractor
   *
   * @param string $step3aContractor
   */
  public function setStep3aContractor($step3aContractor)
  {
    $this->step3aContractor = $step3aContractor;
  }

  /**
   * Get step3aContractor
   *
   * @return string 
   */
  public function getStep3aContractor()
  {
    return $this->step3aContractor;
  }

  /**
   * Set step3bWorkDone
   *
   * @param string $step3bWorkDone
   */
  public function setStep3bWorkDone($step3bWorkDone)
  {
    $this->step3bWorkDone = $step3bWorkDone;
  }

  /**
   * Get step3bWorkDone
   *
   * @return string 
   */
  public function getStep3bWorkDone()
  {
    return $this->step3bWorkDone;
  }

  /**
   * Set step2bSubmitted
   *
   * @param boolean $step2bSubmitted
   */
  public function setStep2bSubmitted($step2bSubmitted)
  {
    $this->step2bSubmitted = $step2bSubmitted;
  }

  /**
   * Get step2bSubmitted
   *
   * @return boolean 
   */
  public function getStep2bSubmitted()
  {
    return $this->step2bSubmitted;
  }

  /**
   * Set step2dCompleted
   *
   * @param boolean $step2dCompleted
   */
  public function setStep2dCompleted($step2dCompleted)
  {
    $this->step2dCompleted = $step2dCompleted;
  }

  /**
   * Get step2dCompleted
   *
   * @return boolean 
   */
  public function getStep2dCompleted()
  {
    return $this->step2dCompleted;
  }

  /**
   * Set step3cHowFinanced
   *
   * @param string $step3cHowFinanced
   */
  public function setStep3cHowFinanced($step3cHowFinanced)
  {
    $this->step3cHowFinanced = $step3cHowFinanced;
  }

  /**
   * Get step3cHowFinanced
   *
   * @return string 
   */
  public function getStep3cHowFinanced()
  {
    return $this->step3cHowFinanced;
  }

  /**
   * Set otherNotes
   *
   * @param text $otherNotes
   */
  public function setOtherNotes($otherNotes)
  {
    $this->otherNotes = $otherNotes;
  }

  /**
   * Get otherNotes
   *
   * @return text 
   */
  public function getOtherNotes()
  {
    return $this->otherNotes;
  }


    /**
     * Set middleInitial
     *
     * @param string $middleInitial
     */
    public function setMiddleInitial($middleInitial)
    {
        $this->middleInitial = $middleInitial;
    }

    /**
     * Get middleInitial
     *
     * @return string 
     */
    public function getMiddleInitial()
    {
        return $this->middleInitial;
    }

    /**
     * Set county
     *
     * @param string $county
     */
    public function setCounty($county)
    {
        $this->county = $county;
    }

    /**
     * Get county
     *
     * @return string 
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Set primaryPhoneType
     *
     * @param string $primaryPhoneType
     */
    public function setPrimaryPhoneType($primaryPhoneType)
    {
        $this->primaryPhoneType = $primaryPhoneType;
    }

    /**
     * Get primaryPhoneType
     *
     * @return string 
     */
    public function getPrimaryPhoneType()
    {
        return $this->primaryPhoneType;
    }

    /**
     * Set secondaryPhone
     *
     * @param string $secondaryPhone
     */
    public function setSecondaryPhone($secondaryPhone)
    {
        $this->secondaryPhone = $secondaryPhone;
    }

    /**
     * Get secondaryPhone
     *
     * @return string 
     */
    public function getSecondaryPhone()
    {
        return $this->secondaryPhone;
    }

    /**
     * Set secondaryPhoneType
     *
     * @param string $secondaryPhoneType
     */
    public function setSecondaryPhoneType($secondaryPhoneType)
    {
        $this->secondaryPhoneType = $secondaryPhoneType;
    }

    /**
     * Get secondaryPhoneType
     *
     * @return string 
     */
    public function getSecondaryPhoneType()
    {
        return $this->secondaryPhoneType;
    }

    /**
     * Set personalEmail
     *
     * @param string $personalEmail
     */
    public function setPersonalEmail($personalEmail)
    {
        $this->personalEmail = $personalEmail;
    }

    /**
     * Get personalEmail
     *
     * @return string 
     */
    public function getPersonalEmail()
    {
        return $this->personalEmail;
    }

    /**
     * Set workEmail
     *
     * @param string $workEmail
     */
    public function setWorkEmail($workEmail)
    {
        $this->workEmail = $workEmail;
    }

    /**
     * Get workEmail
     *
     * @return string 
     */
    public function getWorkEmail()
    {
        return $this->workEmail;
    }

    /**
     * Set ProgramSource
     *
     * @param string $ProgramSource
     */
    public function setProgramSource($ProgramSource)
    {
        $this->ProgramSource = $ProgramSource;
    }

    /**
     * Get ProgramSource
     *
     * @return string 
     */
    public function getProgramSource()
    {
        return $this->ProgramSource;
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
     * Set orgTitle
     *
     * @param string $orgTitle
     */
    public function setOrgTitle($orgTitle)
    {
        $this->orgTitle = $orgTitle;
    }

    /**
     * Get orgTitle
     *
     * @return string 
     */
    public function getOrgTitle()
    {
        return $this->orgTitle;
    }

    /**
     * Set orgAddress
     *
     * @param string $orgAddress
     */
    public function setOrgAddress($orgAddress)
    {
        $this->orgAddress = $orgAddress;
    }

    /**
     * Get orgAddress
     *
     * @return string 
     */
    public function getOrgAddress()
    {
        return $this->orgAddress;
    }

    /**
     * Set orgCity
     *
     * @param string $orgCity
     */
    public function setOrgCity($orgCity)
    {
        $this->orgCity = $orgCity;
    }

    /**
     * Get orgCity
     *
     * @return string 
     */
    public function getOrgCity()
    {
        return $this->orgCity;
    }

    /**
     * Set orgState
     *
     * @param string $orgState
     */
    public function setOrgState($orgState)
    {
        $this->orgState = $orgState;
    }

    /**
     * Get orgState
     *
     * @return string 
     */
    public function getOrgState()
    {
        return $this->orgState;
    }

    /**
     * Set orgZip
     *
     * @param string $orgZip
     */
    public function setOrgZip($orgZip)
    {
        $this->orgZip = $orgZip;
    }

    /**
     * Get orgZip
     *
     * @return string 
     */
    public function getOrgZip()
    {
        return $this->orgZip;
    }

    /**
     * Set orgCounty
     *
     * @param string $orgCounty
     */
    public function setOrgCounty($orgCounty)
    {
        $this->orgCounty = $orgCounty;
    }

    /**
     * Get orgCounty
     *
     * @return string 
     */
    public function getOrgCounty()
    {
        return $this->orgCounty;
    }

    /**
     * Set website
     *
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set pledge
     *
     * @param string $pledge
     */
    public function setPledge($pledge)
    {
        $this->pledge = $pledge;
    }

    /**
     * Get pledge
     *
     * @return string 
     */
    public function getPledge()
    {
        return $this->pledge;
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

    /**
     * Set leadType
     *
     * @param string $leadType
     */
    public function setLeadType($leadType)
    {
        $this->leadType = $leadType;
    }

    /**
     * Get leadType
     *
     * @return string 
     */
    public function getLeadType()
    {
        return $this->leadType;
    }

    /**
     * Set leadStatus
     *
     * @param string $leadStatus
     */
    public function setLeadStatus($leadStatus)
    {
        $this->leadStatus = $leadStatus;
    }

    /**
     * Get leadStatus
     *
     * @return string 
     */
    public function getLeadStatus()
    {
        return $this->leadStatus;
    }

    /**
     * Set DateOfNextFollowup
     *
     * @param date $dateOfNextFollowup
     */
    public function setDateOfNextFollowup($dateOfNextFollowup)
    {
        $this->DateOfNextFollowup = $dateOfNextFollowup;
    }

    /**
     * Get DateOfNextFollowup
     *
     * @return date 
     */
    public function getDateOfNextFollowup()
    {
        return $this->DateOfNextFollowup;
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
     * Set leadReferral
     *
     * @param string $leadReferral
     */
    public function setLeadReferral($leadReferral)
    {
        $this->leadReferral = $leadReferral;
    }

    /**
     * Get leadReferral
     *
     * @return string 
     */
    public function getLeadReferral()
    {
        return $this->leadReferral;
    }

    /**
     * Set BECCTeam
     *
     * @param string $bECCTeam
     */
    public function setBECCTeam($bECCTeam)
    {
        $this->BECCTeam = $bECCTeam;
    }

    /**
     * Get BECCTeam
     *
     * @return string 
     */
    public function getBECCTeam()
    {
        return $this->BECCTeam;
    }

    /**
     * Set visitPeriod
     *
     * @param string $visitPeriod
     */
    public function setVisitPeriod($visitPeriod)
    {
        $this->visitPeriod = $visitPeriod;
    }

    /**
     * Get visitPeriod
     *
     * @return string 
     */
    public function getVisitPeriod()
    {
        return $this->visitPeriod;
    }

    /**
     * Set rank
     *
     * @param string $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * Get rank
     *
     * @return string 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set barriers
     *
     * @param string $barriers
     */
    public function setBarriers($barriers)
    {
        $this->barriers = $barriers;
    }

    /**
     * Get barriers
     *
     * @return string 
     */
    public function getBarriers()
    {
        return $this->barriers;
    }

    /**
     * Set october2011Raffle
     *
     * @param boolean $october2011Raffle
     */
    public function setOctober2011Raffle($october2011Raffle)
    {
        $this->october2011Raffle = $october2011Raffle;
    }

    /**
     * Get october2011Raffle
     *
     * @return boolean 
     */
    public function getOctober2011Raffle()
    {
        return $this->october2011Raffle;
    }

    /**
     * Set interestedInVisit
     *
     * @param boolean $interestedInVisit
     */
    public function setInterestedInVisit($interestedInVisit)
    {
        $this->interestedInVisit = $interestedInVisit;
    }

    /**
     * Get interestedInVisit
     *
     * @return boolean 
     */
    public function getInterestedInVisit()
    {
        return $this->interestedInVisit;
    }

    /**
     * Set homeowner
     *
     * @param boolean $homeowner
     */
    public function setHomeowner($homeowner)
    {
        $this->homeowner = $homeowner;
    }

    /**
     * Get homeowner
     *
     * @return boolean 
     */
    public function getHomeowner()
    {
        return $this->homeowner;
    }

    /**
     * Set renter
     *
     * @param boolean $renter
     */
    public function setRenter($renter)
    {
        $this->renter = $renter;
    }

    /**
     * Get renter
     *
     * @return boolean 
     */
    public function getRenter()
    {
        return $this->renter;
    }

    /**
     * Set landlord
     *
     * @param boolean $landlord
     */
    public function setLandlord($landlord)
    {
        $this->landlord = $landlord;
    }

    /**
     * Get landlord
     *
     * @return boolean 
     */
    public function getLandlord()
    {
        return $this->landlord;
    }

    /**
     * Add LeadEvents
     *
     * @param GJGNY\DataToolBundle\Entity\LeadEvent $leadEvents
     */
    public function addLeadEvent(\GJGNY\DataToolBundle\Entity\LeadEvent $leadEvents)
    {
        $this->LeadEvents[] = $leadEvents;
    }
}