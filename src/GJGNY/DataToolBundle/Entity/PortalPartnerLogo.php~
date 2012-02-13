<?php

namespace GJGNY\DataToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GJGNY\DataToolBundle\Entity\PortalPartnerLogo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GJGNY\DataToolBundle\Entity\PortalPartnerLogoRepository")
 */
class PortalPartnerLogo
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
     * @var string $filename
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255, nullable="true")
     */
    private $url;
    
    /**
     * @var string $rank
     *
     * @ORM\Column(name="rank", type="integer", nullable="true")
     */
    private $rank;
    
    /** @ORM\ManyToOne(targetEntity="Portal", inversedBy="partnerLogos") */
    protected $portal;

    public function __construct()
    {
        $this->rank = 0;
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
     * @var string $file
     *
     * @ORM\Column(name="file", type="string", length=255, nullable=true)
     */
    protected $file;    
    
    /**
     * Set filename
     *
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
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
    
    public function getAbsolutePath()
    {
        return null === $this->filename ? null : $this->getUploadRootDir() . '/' . $this->filename;
    }

    public function getWebPath()
    {
        return null === $this->filename ? null : $this->getUploadDir() . '/' . $this->filename;
    }

    protected function getUploadDir()
    {
        return __DIR__.'/../../../../web/images/Portals';
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if(null === $this->file)
        {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the target filename to move to
        $this->file->move($this->getUploadDir(), $this->file->getClientOriginalName());

        // set the path property to the filename where you'ved saved the file
        $this->setFilename($this->file->getClientOriginalName());

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
    
    public function __toString()
    {
        return $this->getFilename();
    }


    /**
     * Set file
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }
}