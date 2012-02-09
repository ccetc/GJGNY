<?php

namespace GJGNY\DataToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GJGNY\DataToolBundle\Entity\Portal
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GJGNY\DataToolBundle\Entity\PortalRepository")
 */
class Portal
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var text $contactUs
     *
     * @ORM\Column(name="contactUs", type="text", nullable="true")
     */
    private $contactUs;

    /**
     * @var text $events
     *
     * @ORM\Column(name="events", type="text", nullable="true")
     */
    private $events;

    /**
     * @var string $mainLogoFilename
     *
     * @ORM\Column(name="mainLogoFilename", type="string", length=255, nullable="true")
     */
    private $mainLogoFilename;
     /**
     * @var string $mainLogoFile
     *
     * @ORM\Column(name="mainLogoFile", type="string", length=255, nullable=true)
     */
    protected $mainLogoFile;    
    /**
     * @var string $mainLogoUrl
     *
     * @ORM\Column(name="mainLogoUrl", type="string", length=255, nullable="true")
     */
    private $mainLogoUrl;

    /** @ORM\OneToMany(targetEntity="PortalPartnerLogo", mappedBy="portal", cascade={"persist", "remove"}) */
    protected $partnerLogos;

    
    public function __toString()
    {
        return $this->getTitle();
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set contactUs
     *
     * @param text $contactUs
     */
    public function setContactUs($contactUs)
    {
        $this->contactUs = $contactUs;
    }

    /**
     * Get contactUs
     *
     * @return text 
     */
    public function getContactUs()
    {
        return $this->contactUs;
    }

    /**
     * Set events
     *
     * @param text $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }

    /**
     * Get events
     *
     * @return text 
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set mainLogoUrl
     *
     * @param string $mainLogoUrl
     */
    public function setMainLogoUrl($mainLogoUrl)
    {
        $this->mainLogoUrl = $mainLogoUrl;
    }

    /**
     * Get mainLogoUrl
     *
     * @return string 
     */
    public function getMainLogoUrl()
    {
        return $this->mainLogoUrl;
    }
    public function __construct()
    {
        $this->partnerLogos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add partnerLogos
     *
     * @param GJGNY\DataToolBundle\Entity\PortalPartnerLogo $partnerLogos
     */
    public function addPortalPartnerLogo(\GJGNY\DataToolBundle\Entity\PortalPartnerLogo $partnerLogos)
    {
        $this->partnerLogos[] = $partnerLogos;
    }

    /**
     * Get partnerLogos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPartnerLogos()
    {
        return $this->partnerLogos;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->mainLogo ? null : $this->getUploadRootDir() . '/' . $this->mainLogo;
    }

    public function getWebPath()
    {
        return null === $this->mainLogo ? null : $this->getUploadDir() . '/' . $this->mainLogo;
    }

    protected function getUploadDir()
    {
        return __DIR__.'/../../../../web/images/Portals';
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if(null === $this->mainLogoFile)
        {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the target filename to move to
        $this->mainLogoFile->move($this->getUploadDir(), $this->mainLogoFile->getClientOriginalName());

        // set the path property to the filename where you'ved saved the file
        $this->setMainLogoFilename($this->mainLogoFile->getClientOriginalName());

        // clean up the file property as you won't need it anymore
        $this->mainLogoFile = null;
    }
    

    /**
     * Set mainLogoFilename
     *
     * @param string $mainLogoFilename
     */
    public function setMainLogoFilename($mainLogoFilename)
    {
        $this->mainLogoFilename = $mainLogoFilename;
    }

    /**
     * Get mainLogoFilename
     *
     * @return string 
     */
    public function getMainLogoFilename()
    {
        return $this->mainLogoFilename;
    }

    /**
     * Set mainLogoFile
     *
     * @param string $mainLogoFile
     */
    public function setMainLogoFile($mainLogoFile)
    {
        $this->mainLogoFile = $mainLogoFile;
    }

    /**
     * Get mainLogoFile
     *
     * @return string 
     */
    public function getMainLogoFile()
    {
        return $this->mainLogoFile;
    }
}