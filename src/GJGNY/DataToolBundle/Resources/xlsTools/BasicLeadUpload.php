<?php

namespace GJGNY\DataToolBundle\Resources\xlsTools;

use \PHPExcel;

/**
 */
class BasicLeadUpload extends SpreadsheetUtilities
{
    public $leadRepository;
    
    public function __construct($filename, $entityManager, $leadRepository)
    {
        $this->leadRepository = $leadRepository;
        
        parent::__construct($filename, $entityManager);
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
        $firstAndLastName = $this->leadRepository->findBy(array(
            'FirstName' => $this->getFirstName($row),
            'LastName' => $this->getLastName($row)
        ));
        
        $lastNameAndAddress = $this->leadRepository->findBy(array(
            'Address' => $this->getAddress($row),
            'LastName' => $this->getLastName($row)
        ));
        
        if($firstAndLastName) {
            return true;
        } else if($lastNameAndAddress) {
            return true;
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
       
    private function getFirstName($row)
    {
        return $this->getVal('A' . $row);
    }

    private function getLastName($row)
    {
        return $this->getVal('B' . $row);
    }

    private function getMiddleInitial($row)
    {
        return $this->getVal('C' . $row);
    }

    private function getAddress($row)
    {
        return $this->getVal('D' . $row);
    }

    private function getCity($row)
    {
        return $this->getVal('E' . $row);
    }

    private function getState($row)
    {
        return $this->getVal('F' . $row);
    }

    private function getZip($row)
    {
        return $this->getVal('G' . $row);
    }

    private function getTown($row)
    {
        return $this->getVal('H' . $row);
    }

    private function getCounty($row)
    {
        return $this->getVal('I' . $row);
    }

    private function getPrimaryPhone($row)
    {
        return $this->getVal('J' . $row);
    }

    private function getPrimaryPhoneType($row)
    {
        return $this->getVal('K' . $row);
    }

    private function getSecondaryPhone($row)
    {
        return $this->getVal('L' . $row);
    }

    private function getSecondaryPhoneType($row)
    {
        return $this->getVal('M' . $row);
    }

    private function getPersonalEmail($row)
    {
        return $this->getVal('N' . $row);
    }
    
    private function getWorkEmail($row)
    {
        return $this->getVal('O' . $row);
    }    
}
