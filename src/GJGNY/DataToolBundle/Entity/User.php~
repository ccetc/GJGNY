<?php
namespace GJGNY\DataToolBundle\Entity;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="GJGNY\DataToolBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
  
    /** @ORM\OneToMany(targetEntity="LeadEvent", mappedBy="enteredBy") */
    protected $LeadEventsEntered;
  
    /** @ORM\OneToMany(targetEntity="LeadEvent", mappedBy="lastUpdatedBy") */
    protected $LeadEventsUpdated;
    
     /** @ORM\OneToMany(targetEntity="Lead", mappedBy="enteredBy") */
    protected $LeadsEntered;
  
    /** @ORM\OneToMany(targetEntity="Lead", mappedBy="lastUpdatedBy") */
    protected $LeadsUpdated;
  
    public function __toString()
    {
      $s = $this->firstName.' ';
      $s .= $this->lastName;
      return $s;
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $firstName
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;
    /**
     * @var string $lastName
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;
    /**
     * @var string $organization
     *
     * @ORM\Column(name="organization", type="string", length=255)
     */
    private $organization;

    /**
     * @var string $county
     *
     * @ORM\Column(name="county", type="string", length=255)
     */
    private $county;

    
    public function __construct()
    {
        parent::__construct();
        // your own logic
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
    
    public function setEmail($email)
    {
         parent::setEmail($email);
         $this->setUsername($email);
    } 

    /**
     * Set firstName
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
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
     * Add LeadEventsEntered
     *
     * @param GJGNY\DataToolBundle\Entity\LeadEvent $leadEventsEntered
     */
    public function addLeadEventsEntered(\GJGNY\DataToolBundle\Entity\LeadEvent $leadEventsEntered)
    {
        $this->LeadEventsEntered[] = $leadEventsEntered;
    }

    /**
     * Get LeadEventsEntered
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLeadEventsEntered()
    {
        return $this->LeadEventsEntered;
    }

    /**
     * Add LeadEventsUpdated
     *
     * @param GJGNY\DataToolBundle\Entity\LeadEvent $leadEventsUpdated
     */
    public function addLeadEventsUpdated(\GJGNY\DataToolBundle\Entity\LeadEvent $leadEventsUpdated)
    {
        $this->LeadEventsUpdated[] = $leadEventsUpdated;
    }

    /**
     * Get LeadEventsUpdated
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLeadEventsUpdated()
    {
        return $this->LeadEventsUpdated;
    }

    /**
     * Add LeadsEntered
     *
     * @param GJGNY\DataToolBundle\Entity\Lead $leadsEntered
     */
    public function addLeadsEntered(\GJGNY\DataToolBundle\Entity\Lead $leadsEntered)
    {
        $this->LeadsEntered[] = $leadsEntered;
    }

    /**
     * Get LeadsEntered
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLeadsEntered()
    {
        return $this->LeadsEntered;
    }

    /**
     * Add LeadsUpdated
     *
     * @param GJGNY\DataToolBundle\Entity\Lead $leadsUpdated
     */
    public function addLeadsUpdated(\GJGNY\DataToolBundle\Entity\Lead $leadsUpdated)
    {
        $this->LeadsUpdated[] = $leadsUpdated;
    }

    /**
     * Get LeadsUpdated
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLeadsUpdated()
    {
        return $this->LeadsUpdated;
    }
}