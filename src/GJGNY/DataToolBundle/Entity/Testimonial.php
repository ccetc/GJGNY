<?php

namespace GJGNY\DataToolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GJGNY\DataToolBundle\Entity\Testimonial
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Testimonial
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
     * @var string $location
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @var string $youtubeUrl
     *
     * @ORM\Column(name="youtubeUrl", type="string", length=255, nullable=true)
     */
    private $youtubeUrl;    

    /**
     * @var string $quote
     *
     * @ORM\Column(name="quote", type="string", length=600, nullable=true)
     */
    private $quote;

    /**
     * @var text $text
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /** @ORM\ManyToOne(targetEntity="Portal", inversedBy="testimonials") */
    protected $portal;

    /**
     * @var string $filename
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @var string $file
     *
     * @ORM\Column(name="file", type="string", length=255, nullable=true)
     */
    protected $file;    

    /**
     * @var smallint $featured
     *
     * @ORM\Column(name="featured", type="boolean", nullable="true")
     */
    private $featured;


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
     * Set quote
     *
     * @param string $quote
     */
    public function setQuote($quote)
    {
        $this->quote = $quote;
    }

    /**
     * Get quote
     *
     * @return string 
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * Set text
     *
     * @param text $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Get text
     *
     * @return text 
     */
    public function getText()
    {
        return $this->text;
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
        return $this->getName();
    }

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
     * Set youtubeUrl
     *
     * @param string $youtubeUrl
     */
    public function setYoutubeUrl($youtubeUrl)
    {
        $this->youtubeUrl = $youtubeUrl;
    }

    /**
     * Get youtubeUrl
     *
     * @return string 
     */
    public function getYoutubeUrl()
    {
        return $this->youtubeUrl;
    }

    public function getYouTubeId()
    {
        return $this->getYouTubeIdFromUrl($this->getYoutubeUrl());
    }
    
    public function getYouTubeIdFromUrl($url)
    {
        $pattern = '%(?:youtube\.com/(?:user/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
        $result = preg_match($pattern, $url, $matches);
        if (false !== $result and isset($matches[1]) && $matches[1] != "") {
           return $matches[1];
        }
        return null;
    }

    /**
     * Set location
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set featured
     *
     * @param boolean $featured
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;
    }

    /**
     * Get featured
     *
     * @return boolean 
     */
    public function getFeatured()
    {
        return $this->featured;
    }
}