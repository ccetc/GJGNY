<?php

namespace GJGNY\DataToolBundle\Resources\xlsTools;

use \PHPExcel;

class CRISDates extends SpreadsheetUtilities
{
    public $leadRepository;
    public $countyRepository;
    
    public function __construct($filename, $admin, $leadRepository, $countyRespository)
    {
        $this->leadRepository = $leadRepository;
        $this->countyRespository = $countyRespository;
        
        parent::__construct($filename, $admin);
    }    

    public function processRow($row)
    {
        $leadFromResNumber = $this->leadRepository->findOneByCrisResNumber($this->getResNumber($row));
        if($leadFromResNumber) {
            $Lead = $leadFromResNumber;
                        
            if($this->getDateAppSubmitted($row)) $Lead->setDateAppSubmitted(new \DateTime($this->getDateAppSubmitted($row)));
            if($this->getDateOfUpgrade($row)) $Lead->setDateOfUpgrade(new \DateTime($this->getDateOfUpgrade($row)));
            if($this->getDateWorkScopeApproved($row)) $Lead->setDateWorkScopeApproved(new \DateTime($this->getDateWorkScopeApproved($row)));
            if($this->getDateAppApproved($row)) $Lead->setDateAppApproved(new \DateTime($this->getDateAppApproved($row)));
            if($this->getDateOfAssessment($row)) $Lead->setDateOfAssessment(new \DateTime($this->getDateOfAssessment($row)));
            if($this->getDateContractorSelected($row)) $Lead->setDateContractorSelected(new \DateTime($this->getDateContractorSelected($row)));
            
            
            $this->updateObject($Lead);
            $this->updates[] = $Lead->getId().'-'.$Lead->getCrisResNumber().': '.$Lead->getFirstName().' '.$Lead->getLastName();
        } else {
            $this->notFound[] = $row.'-'.$this->getResNumber($row);
        }
    }

    protected function getResNumber($row)
    {
        return $this->getVal('A' . $row);        
    }    
    
    protected function getDateAppSubmitted($row)
    {
        return $this->getDateTimeVal('G' . $row);
    }    

    protected function getDateAppApproved($row)
    {
        $approvedA = $this->getDateTimeVal('H' . $row);
        $approvedB = $this->getDateTimeVal('I' . $row);
        
        if(isset($approvedA) && $approvedA != "") {
            return $approvedA;
        } else if(isset($approvedB) && $approvedB != "") {
            return $approvedB;
        } else {
            return null;
        }
    }    

    protected function getDateOfAssessment($row)
    {
        return $this->getDateTimeVal('Q' . $row);
    }    

    protected function getDateOfUpgrade($row)
    {
        return $this->getDateTimeVal('S' . $row);
    }    

    protected function getDateWorkScopeApproved($row)
    {
        return $this->getDateTimeVal('R' . $row);
    }    
    
    protected function getDateContractorSelected($row)
    {
        return $this->getDateTimeVal('P' . $row);
    }    
    
}
