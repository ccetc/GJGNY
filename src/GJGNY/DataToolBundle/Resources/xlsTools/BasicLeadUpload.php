<?php

namespace GJGNY\DataToolBundle\Resources\xlsTools;

use \PHPExcel;

/**
 */
class BasicLeadUpload extends SpreadsheetUtilities
{
    public $leadRepository;
    
    public function __construct($filename, $admin, $leadRepository)
    {
        $this->leadRepository = $leadRepository;
        
        parent::__construct($filename, $admin);
    }    

    public function processRow($row)
    {
        if($this->checkForDuplicates($row)) {
            $this->duplicates[] = $this->getFirstName($row).' '.$this->getLastName($row);
        } else {
            $Lead = $this->createLead();
            $Lead = $this->setBasicFields($Lead, $row);
            $Lead = $this->setExtraFields($Lead, $row);
            $this->persistObject($Lead);
            $this->insertions[] = $this->getFirstName($row).' '.$this->getLastName($row);
        }
    }
    
    public function checkForDuplicates($row)
    {
        $firstAndLastNameAndCity = $this->leadRepository->findOneBy(array(
            'FirstName' => $this->getFirstName($row),
            'LastName' => $this->getLastName($row),
            'City' => $this->getCity($row)            
        ));
        
        $lastNameAndAddress = $this->leadRepository->findOneBy(array(
            'Address' => $this->getAddress($row),
            'LastName' => $this->getLastName($row)
        ));
        
        if($firstAndLastNameAndCity) {
            return $firstAndLastNameAndCity;
        } else if($lastNameAndAddress) {
            return $lastNameAndAddress;
        } else {
            return false;
        }
                
    }
    
    public function createLead()
    {
        return new \GJGNY\DataToolBundle\Entity\Lead();
    }

    public function setBasicFields($Lead, $row)
    {
        $Lead->setFirstName($this->getFirstName($row));
        $Lead->setLastName($this->getLastName($row));
        $Lead->setMiddleInitial($this->getMiddleInitial($row));
        $Lead->setAddress($this->getAddress($row));
        $Lead->setCity($this->getCity($row));
        $Lead->setState($this->getState($row));
        $Lead->setZip($this->getZip($row));
        $Lead->setCounty($this->getCounty($row));
        $Lead->setPhone($this->getPrimaryPhone($row));
        $Lead->setPrimaryPhoneType($this->getPrimaryPhoneType($row));
        $Lead->setSecondaryPhone($this->getSecondaryPhone($row));
        $Lead->setSecondaryPhoneType($this->getSecondaryPhoneType($row));
        $Lead->setPersonalEmail($this->getPersonalEmail($row));
        $Lead->setWorkEmail($this->getWorkEmail($row));

        $Lead->setDatetimeEntered(new \DateTime());
        $Lead->setDatetimeLastUpdated(new \DateTime());
        $Lead->setUploadedViaXls(true);
        
        return $Lead;
    }
    
    public function setExtraFields($Lead, $row)
    {
        
    }
       
    protected function getFirstName($row)
    {
        return $this->getVal('A' . $row);
    }

    protected function getLastName($row)
    {
        return $this->getVal('B' . $row);
    }

    protected function getMiddleInitial($row)
    {
        return $this->getVal('C' . $row);
    }

    protected function getAddress($row)
    {
        return $this->getVal('D' . $row);
    }

    protected function getCity($row)
    {
        return $this->getVal('E' . $row);
    }

    protected function getState($row)
    {
        return $this->getVal('F' . $row);
    }

    protected function getZip($row)
    {
        return $this->getVal('G' . $row);
    }

    protected function getTown($row)
    {
        return $this->getVal('H' . $row);
    }

    protected function getCounty($row)
    {
        return $this->getVal('I' . $row);
    }

    protected function getPrimaryPhone($row)
    {
        return $this->getVal('J' . $row);
    }

    protected function getPrimaryPhoneType($row)
    {
        return $this->getVal('K' . $row);
    }

    protected function getSecondaryPhone($row)
    {
        return $this->getVal('L' . $row);
    }

    protected function getSecondaryPhoneType($row)
    {
        return $this->getVal('M' . $row);
    }

    protected function getPersonalEmail($row)
    {
        return $this->getVal('N' . $row);
    }
    
    protected function getWorkEmail($row)
    {
        return $this->getVal('O' . $row);
    }    
}
