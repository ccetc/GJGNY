<?php

namespace GJGNY\DataToolBundle\Resources\xlsTools;

use \PHPExcel;

class BasicLeadUpload extends SpreadsheetUtilities
{
    public $leadRepository;
    
    public function __construct($filename, $admin, $leadRepository, $countyRespository)
    {
        $this->leadRepository = $leadRepository;
        $this->countyRespository = $countyRespository;
        
        /**
         * array of arrays of field name, method name pairs
         */
        $this->fieldPairsToCheckForDuplicates = array(
            array(
                'personalEmail' => 'getPersonalEmail'
            ),
            array(
                'workEmail' => 'getWorkEmail'
            ),
            array(
                'personalEmail' => 'getWorkEmail'
            ),
            array(
                'workEmail' => 'getPersonalEmail'
            ),
            array(
                'LastName' => 'getLastName',
                'phone' => 'getPrimaryPhone'
            ),
            array(
                'FirstName' => 'getFirstName',
                'phone' => 'getPrimaryPhone'
            ),
            array(
                'LastName' => 'getLastName',
                'secondaryPhone' => 'getPrimaryPhone'
            ),
            array(
                'FirstName' => 'getFirstName',
                'secondaryPhone' => 'getPrimaryPhone'
            ),
            array(
                'LastName' => 'getLastName',
                'phone' => 'getSecondaryPhone'
            ),
            array(
                'FirstName' => 'getFirstName',
                'phone' => 'getSecondaryPhone'
            ),
            array(
                'FirstName' => 'getFirstName',
                'Address' => 'getAddress'
            ),
            array(
                'LastName' => 'getLastName',
                'Address' => 'getAddress'
            ),
            array(
                'FirstName' => 'getFirstName',
                'LastName' => 'getLastName',
                'Zip' => 'getZip'
            )
        );
        
        parent::__construct($filename, $admin);
    }    

    public function processRow($row)
    {
        if($this->checkForDuplicates($row)) {
            $duplicate = $this->checkForDuplicates($row);
            $this->duplicates[] = $this->getFirstName($row).' '.$this->getLastName($row).' (Duplicate: '.$duplicate->getFirstName().' '.$duplicate->getLastName.')';
        } else {
            $Lead = $this->createLead();
            $Lead = $this->setBasicFields($Lead, $row);
            $Lead = $this->setExtraFields($Lead, $row);
            $this->createObject($Lead);
            $this->insertions[] = $this->getFirstName($row).' '.$this->getLastName($row);
        }
    }
    
    public function checkForDuplicates($row)
    {
        foreach($this->fieldPairsToCheckForDuplicates as $fieldPairs)
        {
            $keysAndValues = array();
            $emptyValueFound = false;
            
            foreach($fieldPairs as $field => $method)
            {
                if($this->$method($row)) $keysAndValues[$field] = $this->$method($row);
                else $emptyValueFound = true; // if any value is empty, it will throw off the pair (ex: check firstName + phone and phone is empty)
            }
            
            if(!$emptyValueFound) {
                $result = $this->leadRepository->findOneBy($keysAndValues);

                if($result) {
                    return $result;
                }
            }
                
        }
        
        return false;
    }
    
    protected $fieldPairsToCheckForDuplicates = array();

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
        $Lead->setPhone($this->getPrimaryPhone($row));
        $Lead->setPrimaryPhoneType($this->getPrimaryPhoneType($row));
        $Lead->setSecondaryPhone($this->getSecondaryPhone($row));
        $Lead->setSecondaryPhoneType($this->getSecondaryPhoneType($row));
        $Lead->setPersonalEmail($this->getPersonalEmail($row));
        $Lead->setWorkEmail($this->getWorkEmail($row));

        if($this->getCounty($row) && $county = $this->countyRespository->findOneByName($this->getCounty($row))) {
            $Lead->setCounty($county);
        }
        
        $Lead->setDatetimeEntered(new \DateTime());
        $Lead->setDatetimeLastUpdated(new \DateTime());
        $Lead->setUploadedViaXls(true);
        
        return $Lead;
    }
    
    public function setExtraFields($Lead, $row)
    {
        // can be implemented by child class
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
