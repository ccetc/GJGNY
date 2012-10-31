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

    /** @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="LeadsEntered")
     *  @ORM\JoinColumn(name="enteredBy_id", referencedColumnName="id", onDelete="SET NULL") 
     */
    protected $enteredBy;

    /**
     * @var date $datetimeEntered
     *
     * @ORM\Column(name="datetimeEntered", type="datetime", nullable="true")
     */
    private $datetimeEntered;

    /** @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="LeadsUpdated")
     *  @ORM\JoinColumn(name="lastUpdatedBy_id", referencedColumnName="id", onDelete="SET NULL") 
     */
    protected $lastUpdatedBy;

    /**
     * @var date $datetimeLastUpdated
     *
     * @ORM\Column(name="datetimeLastUpdated", type="datetime", nullable="true")
     */
    private $datetimeLastUpdated;
    
    /** @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="LeadsAssignedTo")
     *  @ORM\JoinColumn(name="userAssignedTo_id", referencedColumnName="id", onDelete="SET NULL") 
     */
    protected $userAssignedTo;
    
    public function __toString()
    {
        $s = $this->FirstName . ' ';
        if(isset($this->middleInitial)) {
            $s .= $this->middleInitial;
            if(!strstr($this->middleInitial, '.'))
                $s .= '. ';
            else
                $s .= ' ';
        }
        $s .= $this->LastName;
        return $s;
    }

    protected static $stateChoices = array(
        'AL' => "Alabama", 'AK' => "Alaska", 'AZ' => "Arizona", 'AR' => "Arkansas", 'CA' => "California", 'CO' => "Colorado", 'CT' => "Connecticut", 'DE' => "Delaware", 'DC' => "District Of Columbia", 'FL' => "Florida", 'GA' => "Georgia", 'HI' => "Hawaii", 'ID' => "Idaho", 'IL' => "Illinois", 'IN' => "Indiana", 'IA' => "Iowa", 'KS' => "Kansas", 'KY' => "Kentucky", 'LA' => "Louisiana", 'ME' => "Maine", 'MD' => "Maryland", 'MA' => "Massachusetts", 'MI' => "Michigan", 'MN' => "Minnesota", 'MS' => "Mississippi", 'MO' => "Missouri", 'MT' => "Montana", 'NE' => "Nebraska", 'NV' => "Nevada", 'NH' => "New Hampshire", 'NJ' => "New Jersey", 'NM' => "New Mexico", 'NY' => "New York", 'NC' => "North Carolina", 'ND' => "North Dakota", 'OH' => "Ohio", 'OK' => "Oklahoma", 'OR' => "Oregon", 'PA' => "Pennsylvania", 'RI' => "Rhode Island", 'SC' => "South Carolina", 'SD' => "South Dakota", 'TN' => "Tennessee", 'TX' => "Texas", 'UT' => "Utah", 'VT' => "Vermont", 'VA' => "Virginia", 'WA' => "Washington", 'WV' => "West Virginia", 'WI' => "Wisconsin", 'WY' => "Wyoming"
    );
    protected static $campaignChoices = array(
        'campaignChoiceTalkingToNeighbors' => 'Give program flyer to neighbor or friends',
        'campaignChoiceFormEnergyTeam' => 'forming an energy team',
        'campaignChoiceAppearInVideo' => 'appear in a testimonial',
        'campaignChoiceVolunteer' => 'becoming a volunteer',
        'campaignChoiceSteward' => 'becoming a senior energy steward',
        'campaignChoiceEvent' => 'presenting at an event',
        'campaignChoicePresent' => 'setup presentation at workplace or organization'
    );
    protected static $SourceOfLeadChoices = array(
        'Contractor' => 'Contractor',
        'CRIS Database' => 'CRIS Database',
        'Door to door canvas' => 'Door to door canvas',
        'E-mail' => 'E-mail',
        'Mailing' => 'Mailing',
        'Neighbor / Friends' => 'Neighbor / Friends',
        'Newspaper Article' => 'Newspaper Article',
        'Phone' => 'Phone',
        'Event' => 'Event',
        'Meeting' => 'Meeting',
        'Program' => 'Program',
        'Presentation' => 'Presentation',
        'Tabling' => 'Tabling',
        'TV News' => 'TV News',
        'Website' => 'Website',
    );
    protected static $howAssessmentFinancedChoices = array(
        'out-of-pocket' => 'out-of-pocket',
        'AHP' => 'AHP',
        'GJGNY Loan' => 'GJGNY Loan'
    );
    protected static $leadStatusChoices = array(
        'not interested' => 'not interested',
        'interested but is a renter' => 'interested but is a renter',
        'active: pre-assessment' => 'active: pre-assessment',
        'stuck: pre-assessment' => 'stuck: pre-assessment',
        'active: post-assessment' => 'active: post-assessment',
        'stuck: post assessment' => 'stuck: post assessment',
	'unresponsive' => 'unresponsive',
        'upgrade complete' => 'upgrade complete',
    );
    
    protected static $upgradeStatusChoices = array(
        'Interested in assessment - No app submitted' => 'Interested in assessment - No app submitted',
        'Referred to WAP / Empower' => 'Referred to WAP / Empower',
        'GJGNY app submitted' => 'GJGNY app submitted',
        'GJGNY app missing information' => 'GJGNY app missing information',
        'GJGNY app denied ' => 'GJGNY app denied ',
        'GJGNY app approved' => 'GJGNY app approved',
        'GJGNY assessment reservation number expired' => 'GJGNY assessment reservation number expired',
        'Assessment Scheduled' => 'Assessment Scheduled',
        'Assessment Complete' => 'Assessment Complete',
        'Applied for financing ' => 'Applied for financing ',
        'Approved for financing ' => 'Approved for financing ',
        'Denied for financing' => 'Denied for financing',
        'Work scope submitted' => 'Work scope submitted',
        'Work scope approved' => 'Work scope approved',
        'Upgrade Complete' => 'Upgrade Complete'
    );
    
    protected static $leadTypeChoices = array(
        'leadTypeUpgrade' => 'Energy Upgrade',
        'leadTypeOutreach' => 'Outreach',
        'leadTypeWorkforce' => 'Workforce'
    );
    protected static $highestLevelOfEducationChoices = array(
        'High School' => 'High School',
        'Associates' => 'Associates',
        'Bachelors' => 'Bachelors',
        'Masters' => 'Masters',
        'Ph.D.' => 'Ph.D.'
    );
    
    protected static $leadCategoryChoices = array (
        'Residential (1-4 Unit)' => 'Residential (1-4 Unit)',
        'Multifamily' => 'Multifamily',
        "Commercial / Non-Profit / Gov't" => "Commercial / Non-Profit / Gov't",
    );
    
    protected static $CRISStatusChoices = array(
        'Approved for free audit' => 'Approved for free audit',
        'Approved for reduced cost audit' => 'Approved for reduced cost audit',
        'Customer Ineligible' => 'Customer Ineligible',
        'Pending/Hold - Customer' => 'Pending/Hold - Customer',
        'Customer Non-Responsive' => 'Customer Non-Responsive',
        'Audit Approval Expired' => 'Audit Approval Expired',
        'Customer selected HP contractor' => 'Customer selected HP contractor',
        'HP Audit Complete' => 'HP Audit Complete',
        'HP work approved' => 'HP work approved',
        'HP work complete' => 'HP work complete'
    );
    
    
    public static function getUpgradeStatusChoices()
    {
        return self::$upgradeStatusChoices;
    }
    
    public static function getCRISStatusChoices()
    {
        return self::$CRISStatusChoices;
    }
            
    public static function getLeadCategoryChoices()
    {
        return self::$leadCategoryChoices;
    }
    
    public static function getHighestLevelOfEducationChoices()
    {
        return self::$highestLevelOfEducationChoices;
    }

    public static function getLeadTypeChoices()
    {
        return self::$leadTypeChoices;
    }

    public static function getLeadStatusChoices()
    {
        return self::$leadStatusChoices;
    }

    public static function getStateChoices()
    {
        return self::$stateChoices;
    }

    public static function getSourceOfLeadChoices()
    {
        return self::$SourceOfLeadChoices;
    }

    public static function getHowAssessmentFinancedChoices()
    {
        return self::$howAssessmentFinancedChoices;
    }

    public static function getCampaignChoices()
    {
        return self::$campaignChoices;
    }

    /** @ORM\OneToMany(targetEntity="LeadEvent", mappedBy="Lead", cascade={"persist", "remove"}) */
    protected $LeadEvents;

    /** @ORM\ManyToOne(targetEntity="Program", inversedBy="Leads") 
     * @ORM\JoinColumn(name="Program_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $Program;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    // Contact information =================================================================
    // =========================================================================

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
     * @ORM\Column(name="Zip", type="string", length=125, nullable="true")
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

    /** @ORM\ManyToOne(targetEntity="County", inversedBy="leads") */
    protected $countyEntity;
    
    
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

    // Lead History =================================================================
    // =========================================================================    
    
    /**
     * @var string $SourceOfLead
     *
     * @ORM\Column(name="SourceOfLead", type="string", length=255, nullable="true")
     */
    private $SourceOfLead;

    /**
     * @var string $DateOfLead
     *
     * @ORM\Column(name="DateOfLead", type="date", nullable="true")
     */
    private $DateOfLead;
    /**
     * @var smallint $needToCall
     *
     * @ORM\Column(name="needToCall", type="boolean", nullable="true")
     */
    private $needToCall;

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
     * @var smallint $appointmentMade
     *
     * @ORM\Column(name="appointmentMade", type="boolean", nullable="true")
     */
    private $appointmentMade;
    /**
     * @var date $dateOfNextAppointment
     *
     * @ORM\Column(name="dateOfNextAppointment", type="date", nullable="true")
     */
    private $dateOfNextAppointment;

    // Lead Type  =================================================================
    // =========================================================================
    /**
     * @var smallint $leadTypeOutreach
     *
     * @ORM\Column(name="leadTypeOutreach", type="boolean", nullable="true")
     */
    private $leadTypeOutreach;

    /**
     * @var smallint $leadTypeUpgrade
     *
     * @ORM\Column(name="leadTypeUpgrade", type="boolean", nullable="true")
     */
    private $leadTypeUpgrade;

    /**
     * @var smallint $leadTypeWorkforce
     *
     * @ORM\Column(name="leadTypeWorkforce", type="boolean", nullable="true")
     */
    private $leadTypeWorkforce;
    /**
     * @var smallint $leadCategory
     *
     * @ORM\Column(name="leadCategory", type="string", nullable="true")
     */
    private $leadCategory;    
    /**
     * @var smallint $homeowner
     *
     * @ORM\Column(name="homeowner", type="boolean", nullable="true")
     */
    private $homeowner;

    /**
     * @var smallint $renter
     *
     * @ORM\Column(name="renter", type="boolean", nullable="true")
     */
    private $renter;

    /**
     * @var smallint $landlord
     *
     * @ORM\Column(name="landlord", type="boolean", nullable="true")
     */
    private $landlord;


    // Organization Information  ===============================================
    // =========================================================================    
    
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
    
    /**
     * @var string $website
     *
     * @ORM\Column(name="website", type="string", length=255, nullable="true")
     */
    private $website;
    
    // Upgrade Status ===================================================================
    // =============================================================================  
    /**
     * @var smallint $step3
     *
     * @ORM\Column(name="step3", type="boolean", nullable="true")
     */
    private $step3;

    /**
     * @var smallint $step2aInterested
     *
     * @ORM\Column(name="step2aInterested", type="boolean", nullable="true")
     */
    private $step2aInterested;

    /**
     * @var smallint $step2bSubmitted
     *
     * @ORM\Column(name="step2bSubmitted", type="boolean", nullable="true")
     */
    private $step2bSubmitted;

    /**
     * @var smallint $step2dCompleted
     *
     * @ORM\Column(name="step2dCompleted", type="boolean", nullable="true")
     */
    private $step2dCompleted;
    /**
     * @var string $step2eContractor
     *
     * @ORM\Column(name="step2eContractor", type="string", length=255, nullable="true")
     */
    private $step2eContractor;

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

    /**
     * @var smallint $reportReceived
     *
     * @ORM\Column(name="reportReceived", type="boolean", nullable="true")
     */
    private $reportReceived;

    /**
     * @var string $scopeOfWorkSubmitted
     *
     * @ORM\Column(name="scopeOfWorkSubmitted", type="string", length=255, nullable="true")
     */
    private $scopeOfWorkSubmitted;

    /**
     * @var date $dateOfAssessment
     *
     * @ORM\Column(name="dateOfAssessment", type="date", nullable="true")
     */
    private $dateOfAssessment;

    /**
     * @var date $dateOfUpgrade
     *
     * @ORM\Column(name="dateOfUpgrade", type="date", nullable="true")
     */
    private $dateOfUpgrade;
    
    /**
     * @var date $dateAppSubmitted
     *
     * @ORM\Column(name="dateAppSubmitted", type="date", nullable="true")
     */
    private $dateAppSubmitted;

    /**
     * @var date $dateAppApproved
     *
     * @ORM\Column(name="dateAppApproved", type="date", nullable="true")
     */
    private $dateAppApproved;
    /**
     * @var date $dateContractorSelected
     *
     * @ORM\Column(name="dateContractorSelected", type="date", nullable="true")
     */
    private $dateContractorSelected;
    /**
     * @var date $dateWorkScopeApproved
     *
     * @ORM\Column(name="dateWorkScopeApproved", type="date", nullable="true")
     */
    private $dateWorkScopeApproved;
    
    
    /**
     * @var string $CRISStatus
     *
     * @ORM\Column(name="CRISStatus", type="string", length=255, nullable="true")
     */
    private $CRISStatus;

    /**
     * @var string $upgradeStatus
     *
     * @ORM\Column(name="upgradeStatus", type="string", length=255, nullable="true")
     */
    private $upgradeStatus;

    /**
     * @var date $upgradeStatusNotes
     *
     * @ORM\Column(name="upgradeStatusNotes", type="text", nullable="true")
     */
    private $upgradeStatusNotes;
    
    // Outreach ============================================================
    // =============================================================================  
    /**
     * @var string $CommunityGroupsConnectedTo
     *
     * @ORM\Column(name="CommunityGroupsConnectedTo", type="string", length=255, nullable="true")
     */
    private $CommunityGroupsConnectedTo;

    /**
     * @var smallint $campaignChoiceTalkingToNeighbors
     *
     * @ORM\Column(name="campaignChoiceTalkingToNeighbors", type="boolean", nullable="true")
     */
    private $campaignChoiceTalkingToNeighbors;

    /**
     * @var smallint $campaignChoiceFormEnergyTeam
     *
     * @ORM\Column(name="campaignChoiceFormEnergyTeam", type="boolean", nullable="true")
     */
    private $campaignChoiceFormEnergyTeam;

    /**
     * @var smallint $campaignChoiceAppearInVideo
     *
     * @ORM\Column(name="campaignChoiceAppearInVideo", type="boolean", nullable="true")
     */
    private $campaignChoiceAppearInVideo;

    /**
     * @var smallint $campaignChoiceShareExperience
     *
     * @ORM\Column(name="campaignChoiceShareExperience", type="boolean", nullable="true")
     */
    private $campaignChoiceShareExperience;

    /**
     * @var smallint $campaignChoiceVolunteer
     *
     * @ORM\Column(name="campaignChoiceVolunteer", type="boolean", nullable="true")
     */
    private $campaignChoiceVolunteer;
    /**
     * @var smallint $campaignChoiceSteward
     *
     * @ORM\Column(name="campaignChoiceSteward", type="boolean", nullable="true")
     */
    private $campaignChoiceSteward;
    /**
     * @var smallint $campaignChoiceEvent
     *
     * @ORM\Column(name="campaignChoiceEvent", type="boolean", nullable="true")
     */
    private $campaignChoiceEvent;
    /**
     * @var smallint $campaignChoicePresent
     *
     * @ORM\Column(name="campaignChoicePresent", type="boolean", nullable="true")
     */
    private $campaignChoicePresent;
    /**
     * @var string $campaignChoiceOther
     *
     * @ORM\Column(name="campaignChoiceOther", type="string", length=255, nullable="true")
     */
    private $campaignChoiceOther;
    

    /**
     * @var string $otherNotes
     *
     * @ORM\Column(name="otherNotes", type="text", nullable="true")
     */
    private $otherNotes;

    
    // WORKFORCE =================================================================
    // =========================================================================
    /**
     * @var string $highestLevelOfEducation
     *
     * @ORM\Column(name="highestLevelOfEducation", type="string", length=255, nullable="true")
     */
    private $highestLevelOfEducation;

    /**
     * @var string $certifications
     *
     * @ORM\Column(name="certifications", type="string", length=255, nullable="true")
     */
    private $certifications;

    /**
     * @var string $trainingExperience
     *
     * @ORM\Column(name="trainingExperience", type="string", length=255, nullable="true")
     */
    private $trainingExperience;

    // Broome Fields ===========================================================
    // =========================================================================
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

    /**
     * @var string $postPledge
     *
     * @ORM\Column(name="postPledge", type="string", length=255, nullable="true")
     */
    private $postPledge;

    /**
     * @var string $leadReferral
     *
     * @ORM\Column(name="leadReferral", type="string", length=255, nullable="true")
     */
    private $leadReferral;    
    /**
     * @var smallint $interestedInVisit
     *
     * @ORM\Column(name="interestedInVisit", type="boolean", nullable="true")
     */
    private $interestedInVisit;    
    
    // Tompkins Fields =================================================================
    // =========================================================================
    /**
     * @var smallint $october2011Raffle
     *
     * @ORM\Column(name="october2011Raffle", type="boolean", nullable="true")
     */
    private $october2011Raffle;

    // utility fields  =================================================================
    // =========================================================================
    /**
     * @var smallint $uploadedViaXls
     *
     * @ORM\Column(name="uploadedViaXls", type="boolean", nullable="true")
     */
    private $uploadedViaXls;

    /**
     * @var string $crisResNumber
     *
     * @ORM\Column(name="crisResNumber", type="string", length=255, nullable="true")
     */
    private $crisResNumber;
    
    /**
     * @var string $dataCounty
     *
     * @ORM\Column(name="dataCounty", type="string", length=255, nullable="true")
     */
    private $dataCounty;    

    
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
        $this->State = 'NY';
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
     * @param \Application\Sonata\UserBundle\Entity\User $enteredBy
     */
    public function setEnteredBy($enteredBy)
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
     * @param \Application\Sonata\UserBundle\Entity\User $lastUpdatedBy
     */
    public function setLastUpdatedBy($lastUpdatedBy)
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

    /**
     * Set Program
     *
     * @param GJGNY\DataToolBundle\Entity\Program $program
     */
    public function setProgram($program)
    {
        $this->Program = $program;
    }

    /**
     * Get Program
     *
     * @return GJGNY\DataToolBundle\Entity\Program 
     */
    public function getProgram()
    {
        return $this->Program;
    }

    /**
     * Set leadTypeOutreach
     *
     * @param boolean $leadTypeOutreach
     */
    public function setLeadTypeOutreach($leadTypeOutreach)
    {
        $this->leadTypeOutreach = $leadTypeOutreach;
    }

    /**
     * Get leadTypeOutreach
     *
     * @return boolean 
     */
    public function getLeadTypeOutreach()
    {
        return $this->leadTypeOutreach;
    }

    /**
     * Set leadTypeUpgrade
     *
     * @param boolean $leadTypeUpgrade
     */
    public function setLeadTypeUpgrade($leadTypeUpgrade)
    {
        $this->leadTypeUpgrade = $leadTypeUpgrade;
    }

    /**
     * Get leadTypeUpgrade
     *
     * @return boolean 
     */
    public function getLeadTypeUpgrade()
    {
        return $this->leadTypeUpgrade;
    }

    /**
     * Set leadTypeWorkforce
     *
     * @param boolean $leadTypeWorkforce
     */
    public function setLeadTypeWorkforce($leadTypeWorkforce)
    {
        $this->leadTypeWorkforce = $leadTypeWorkforce;
    }

    /**
     * Get leadTypeWorkforce
     *
     * @return boolean 
     */
    public function getLeadTypeWorkforce()
    {
        return $this->leadTypeWorkforce;
    }

    /**
     * Set highestLevelOfEducation
     *
     * @param string $highestLevelOfEducation
     */
    public function setHighestLevelOfEducation($highestLevelOfEducation)
    {
        $this->highestLevelOfEducation = $highestLevelOfEducation;
    }

    /**
     * Get highestLevelOfEducation
     *
     * @return string 
     */
    public function getHighestLevelOfEducation()
    {
        return $this->highestLevelOfEducation;
    }

    /**
     * Set certifications
     *
     * @param string $certifications
     */
    public function setCertifications($certifications)
    {
        $this->certifications = $certifications;
    }

    /**
     * Get certifications
     *
     * @return string 
     */
    public function getCertifications()
    {
        return $this->certifications;
    }

    /**
     * Set trainingExperience
     *
     * @param string $trainingExperience
     */
    public function setTrainingExperience($trainingExperience)
    {
        $this->trainingExperience = $trainingExperience;
    }

    /**
     * Get trainingExperience
     *
     * @return string 
     */
    public function getTrainingExperience()
    {
        return $this->trainingExperience;
    }

    /**
     * Set postPledge
     *
     * @param string $postPledge
     */
    public function setPostPledge($postPledge)
    {
        $this->postPledge = $postPledge;
    }

    /**
     * Get postPledge
     *
     * @return string 
     */
    public function getPostPledge()
    {
        return $this->postPledge;
    }

    /**
     * Set reportReceived
     *
     * @param boolean $reportReceived
     */
    public function setReportReceived($reportReceived)
    {
        $this->reportReceived = $reportReceived;
    }

    /**
     * Get reportReceived
     *
     * @return boolean 
     */
    public function getReportReceived()
    {
        return $this->reportReceived;
    }

    /**
     * Set scopeOfWorkSubmitted
     *
     * @param string $scopeOfWorkSubmitted
     */
    public function setScopeOfWorkSubmitted($scopeOfWorkSubmitted)
    {
        $this->scopeOfWorkSubmitted = $scopeOfWorkSubmitted;
    }

    /**
     * Get scopeOfWorkSubmitted
     *
     * @return string 
     */
    public function getScopeOfWorkSubmitted()
    {
        return $this->scopeOfWorkSubmitted;
    }

    /**
     * Set dateOfAssessment
     *
     * @param date $dateOfAssessment
     */
    public function setDateOfAssessment($dateOfAssessment)
    {
        $this->dateOfAssessment = $dateOfAssessment;
    }

    /**
     * Get dateOfAssessment
     *
     * @return date 
     */
    public function getDateOfAssessment()
    {
        return $this->dateOfAssessment;
    }

    /**
     * Set dateOfUpgrade
     *
     * @param date $dateOfUpgrade
     */
    public function setDateOfUpgrade($dateOfUpgrade)
    {
        $this->dateOfUpgrade = $dateOfUpgrade;
    }

    /**
     * Get dateOfUpgrade
     *
     * @return date 
     */
    public function getDateOfUpgrade()
    {
        return $this->dateOfUpgrade;
    }

    /**
     * Set upgradeStatusNotes
     *
     * @param text $upgradeStatusNotes
     */
    public function setUpgradeStatusNotes($upgradeStatusNotes)
    {
        $this->upgradeStatusNotes = $upgradeStatusNotes;
    }

    /**
     * Get upgradeStatusNotes
     *
     * @return text 
     */
    public function getUpgradeStatusNotes()
    {
        return $this->upgradeStatusNotes;
    }


    /**
     * Set leadCategory
     *
     * @param boolean $leadCategory
     */
    public function setLeadCategory($leadCategory)
    {
        $this->leadCategory = $leadCategory;
    }

    /**
     * Get leadCategory
     *
     * @return boolean 
     */
    public function getLeadCategory()
    {
        return $this->leadCategory;
    }

    /**
     * Set campaignChoiceVolunteer
     *
     * @param boolean $campaignChoiceVolunteer
     */
    public function setCampaignChoiceVolunteer($campaignChoiceVolunteer)
    {
        $this->campaignChoiceVolunteer = $campaignChoiceVolunteer;
    }

    /**
     * Get campaignChoiceVolunteer
     *
     * @return boolean 
     */
    public function getCampaignChoiceVolunteer()
    {
        return $this->campaignChoiceVolunteer;
    }

    /**
     * Set campaignChoiceSteward
     *
     * @param boolean $campaignChoiceSteward
     */
    public function setCampaignChoiceSteward($campaignChoiceSteward)
    {
        $this->campaignChoiceSteward = $campaignChoiceSteward;
    }

    /**
     * Get campaignChoiceSteward
     *
     * @return boolean 
     */
    public function getCampaignChoiceSteward()
    {
        return $this->campaignChoiceSteward;
    }

    /**
     * Set campaignChoiceEvent
     *
     * @param boolean $campaignChoiceEvent
     */
    public function setCampaignChoiceEvent($campaignChoiceEvent)
    {
        $this->campaignChoiceEvent = $campaignChoiceEvent;
    }

    /**
     * Get campaignChoiceEvent
     *
     * @return boolean 
     */
    public function getCampaignChoiceEvent()
    {
        return $this->campaignChoiceEvent;
    }

    /**
     * Set campaignChoiceOther
     *
     * @param string $campaignChoiceOther
     */
    public function setCampaignChoiceOther($campaignChoiceOther)
    {
        $this->campaignChoiceOther = $campaignChoiceOther;
    }

    /**
     * Get campaignChoiceOther
     *
     * @return string 
     */
    public function getCampaignChoiceOther()
    {
        return $this->campaignChoiceOther;
    }

    /**
     * Set needToCall
     *
     * @param boolean $needToCall
     */
    public function setNeedToCall($needToCall)
    {
        $this->needToCall = $needToCall;
    }

    /**
     * Get needToCall
     *
     * @return boolean 
     */
    public function getNeedToCall()
    {
        return $this->needToCall;
    }

    /**
     * Set uploadedViaXls
     *
     * @param boolean $uploadedViaXls
     */
    public function setUploadedViaXls($uploadedViaXls)
    {
        $this->uploadedViaXls = $uploadedViaXls;
    }

    /**
     * Get uploadedViaXls
     *
     * @return boolean 
     */
    public function getUploadedViaXls()
    {
        return $this->uploadedViaXls;
    }

    /**
     * Set CRISStatus
     *
     * @param string $cRISStatus
     */
    public function setCRISStatus($cRISStatus)
    {
        $this->CRISStatus = $cRISStatus;
    }

    /**
     * Get CRISStatus
     *
     * @return string 
     */
    public function getCRISStatus()
    {
        return $this->CRISStatus;
    }

    /**
     * Set step2eContractor
     *
     * @param string $step2eContractor
     */
    public function setStep2eContractor($step2eContractor)
    {
        $this->step2eContractor = $step2eContractor;
    }

    /**
     * Get step2eContractor
     *
     * @return string 
     */
    public function getStep2eContractor()
    {
        return $this->step2eContractor;
    }

    /**
     * Set userAssignedTo
     *
     */
    public function setUserAssignedTo($userAssignedTo)
    {
        $this->userAssignedTo = $userAssignedTo;
    }

    /**
     * Get userAssignedTo
     *
     * @return Application\Sonata\UserBundle\Entity\User 
     */
    public function getUserAssignedTo()
    {
        return $this->userAssignedTo;
    }

    /**
     * Set appointmentMade
     *
     * @param boolean $appointmentMade
     */
    public function setAppointmentMade($appointmentMade)
    {
        $this->appointmentMade = $appointmentMade;
    }

    /**
     * Get appointmentMade
     *
     * @return boolean 
     */
    public function getAppointmentMade()
    {
        return $this->appointmentMade;
    }

    /**
     * Set dateOfNextAppointment
     *
     * @param date $dateOfNextAppointment
     */
    public function setDateOfNextAppointment($dateOfNextAppointment)
    {
        $this->dateOfNextAppointment = $dateOfNextAppointment;
    }

    /**
     * Get dateOfNextAppointment
     *
     * @return date 
     */
    public function getDateOfNextAppointment()
    {
        return $this->dateOfNextAppointment;
    }

    /**
     * Set campaignChoicePresent
     *
     * @param boolean $campaignChoicePresent
     */
    public function setCampaignChoicePresent($campaignChoicePresent)
    {
        $this->campaignChoicePresent = $campaignChoicePresent;
    }

    /**
     * Get campaignChoicePresent
     *
     * @return boolean 
     */
    public function getCampaignChoicePresent()
    {
        return $this->campaignChoicePresent;
    }

    /**
     * Set upgradeStatus
     *
     * @param string $upgradeStatus
     */
    public function setUpgradeStatus($upgradeStatus)
    {
        $this->upgradeStatus = $upgradeStatus;
    }

    /**
     * Get upgradeStatus
     *
     * @return string 
     */
    public function getUpgradeStatus()
    {
        return $this->upgradeStatus;
    }

    /**
     * Set dateAppSubmitted
     *
     * @param date $dateAppSubmitted
     */
    public function setDateAppSubmitted($dateAppSubmitted)
    {
        $this->dateAppSubmitted = $dateAppSubmitted;
    }

    /**
     * Get dateAppSubmitted
     *
     * @return date 
     */
    public function getDateAppSubmitted()
    {
        return $this->dateAppSubmitted;
    }

    /**
     * Set dateAppApproved
     *
     * @param date $dateAppApproved
     */
    public function setDateAppApproved($dateAppApproved)
    {
        $this->dateAppApproved = $dateAppApproved;
    }

    /**
     * Get dateAppApproved
     *
     * @return date 
     */
    public function getDateAppApproved()
    {
        return $this->dateAppApproved;
    }

    /**
     * Set dateContractorSelected
     *
     * @param date $dateContractorSelected
     */
    public function setDateContractorSelected($dateContractorSelected)
    {
        $this->dateContractorSelected = $dateContractorSelected;
    }

    /**
     * Get dateContractorSelected
     *
     * @return date 
     */
    public function getDateContractorSelected()
    {
        return $this->dateContractorSelected;
    }

    /**
     * Set dateWorkScopeApproved
     *
     * @param date $dateWorkScopeApproved
     */
    public function setDateWorkScopeApproved($dateWorkScopeApproved)
    {
        $this->dateWorkScopeApproved = $dateWorkScopeApproved;
    }

    /**
     * Get dateWorkScopeApproved
     *
     * @return date 
     */
    public function getDateWorkScopeApproved()
    {
        return $this->dateWorkScopeApproved;
    }

    /**
     * Set countyEntity
     *
     * @param GJGNY\DataToolBundle\Entity\County $countyEntity
     */
    public function setCountyEntity(\GJGNY\DataToolBundle\Entity\County $countyEntity)
    {
        $this->countyEntity = $countyEntity;
    }

    /**
     * Get countyEntity
     *
     * @return GJGNY\DataToolBundle\Entity\County 
     */
    public function getCountyEntity()
    {
        return $this->countyEntity;
    }

    /**
     * Set crisResNumber
     *
     * @param string $crisResNumber
     */
    public function setCrisResNumber($crisResNumber)
    {
        $this->crisResNumber = $crisResNumber;
    }

    /**
     * Get crisResNumber
     *
     * @return string 
     */
    public function getCrisResNumber()
    {
        return $this->crisResNumber;
    }
}