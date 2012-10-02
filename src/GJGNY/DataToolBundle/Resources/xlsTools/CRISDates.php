<?php

namespace GJGNY\DataToolBundle\Resources\xlsTools;

use \PHPExcel;

class CRISDates extends BasicLeadUpload
{    
    public function __construct($filename, $admin, $leadRepository, $countyRepository)
    {
        parent::__construct($filename, $admin, $leadRepository, $countyRepository);
    
        $this->fieldPairsToCheckForDuplicates[] = array(
                'FirstName' => 'getFirstName',
                'LastName' => 'getLastName',
                'Zip' => 'getNormalZip'
        );     
    }        

    public function processRow($row)
    {
        $leadFromResNumber = $this->leadRepository->findOneByCrisResNumber($this->getResNumber($row));
        $leadFromBasicInfo = $this->checkForDuplicates($row);
        if($leadFromResNumber) {
            $this->updateStatusDates($leadFromResNumber, $row);
        } else if($leadFromBasicInfo) {
            $this->updateStatusDates($leadFromBasicInfo, $row);            
        } else {
            $this->notFound[] = $row.'-'.$this->getResNumber($row)."-".$this->getFirstName($row)."-".$this->getLastName($row);
        }
    }
    
    protected function updateStatusDates($Lead, $row)
    {
        if($this->getDateAppSubmitted($row)) $Lead->setDateAppSubmitted(new \DateTime($this->getDateAppSubmitted($row)));
        if($this->getDateOfUpgrade($row)) $Lead->setDateOfUpgrade(new \DateTime($this->getDateOfUpgrade($row)));
        if($this->getDateWorkScopeApproved($row)) $Lead->setDateWorkScopeApproved(new \DateTime($this->getDateWorkScopeApproved($row)));
        if($this->getDateAppApproved($row)) $Lead->setDateAppApproved(new \DateTime($this->getDateAppApproved($row)));
        if($this->getDateOfAssessment($row)) $Lead->setDateOfAssessment(new \DateTime($this->getDateOfAssessment($row)));
        if($this->getDateContractorSelected($row)) $Lead->setDateContractorSelected(new \DateTime($this->getDateContractorSelected($row)));
        
        $this->updateObject($Lead);
        $this->updates[] = $Lead->getId().'-'.$Lead->getCrisResNumber().': '.$Lead->getFirstName().' '.$Lead->getLastName();
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
        protected function getCRISStatus($row)
    {
        return $this->getVal('L' . $row);
    }
    
    protected function getFirstName($row)
    {
        return $this->getVal('B' . $row);
    }

    protected function getLastName($row)
    {
        return $this->getVal('C' . $row);
    }

    protected function getMiddleInitial($row)
    {
        return null;
    }

    protected function getAddress($row)
    {
        return $this->getVal('D' . $row);
    }

    protected function getState($row)
    {
        return null;
    }

    protected function getZip($row)
    {
        return $this->getVal('F' . $row);   
    }    
   
    protected function getCity($row)
    {
        return ucwords(strtolower($this->getVal('E' . $row)));
    }
    
    protected function getTown($row)
    {
        return null;
    }

    protected function getCounty($row)
    {
        return null;
    }

    protected function getPrimaryPhone($row)
    {
        return null;
    }

    protected function getPrimaryPhoneType($row)
    {
        return null;
    }

    protected function getSecondaryPhone($row)
    {
        return null;
    }

    protected function getSecondaryPhoneType($row)
    {
        return null;
    }
    
    protected function getNormalZip($row)
    {
        $zipParts = explode('-', $this->getZip($row));
        return $zipParts[0];
    }

    protected function getPersonalEmail($row)
    {
        return null;
    }
    
    protected function getWorkEmail($row)
    {
        return null;
    } 
    
    protected $tompkinsZips = array('13053', '13062', '13068', '13073', '13102', '14817', '14850', '14851', '14852', '14853', '14854', '14867', '14881', '14882', '14886', '14814', '14816', '14825', '14838', '14844', '14845', '14861', '14854', '14871', '14872', '14889', '12894', '14901', '14902', '14903', '14904', '14905', '14925', '14805', '14812', '14818', '14824', '14841', '14863', '14865', '14869', '14876', '14887', '14891', '14893', '14529', '14572', '14801', '14807', '14808', '14809', '14810', '14815', '14819', '14820', '14821', '14823', '14826', '14827', '14830', '14831', '14839', '14840', '14843', '14855', '14856', '14858', '14870', '14873', '14874', '14877', '14879', '14885', '14898');
    protected $broomeZips = array('13737', '13744', '13745', '13746', '13748', '13749', '13754', '13760', '13761', '13762', '13763', '13777', '13787', '13790', '13794', '13795', '13797', '13802', '13813', '13826', '13833', '13848', '13850', '13851', '13862', '13865', '13901', '13902', '13903', '13904', '13905', '13732', '13734', '13736', '13743', '13811', '13812', '13827', '13835', '13840', '13845', '13864', '14859', '14883', '14892', '12064', '12116', '12155', '12197', '13315', '13320', '13326', '13333', '13335', '13337', '13342', '13348', '13415', '13429', '13450', '13457', '13468', '13482', '13485', '13488', '13747', '13776', '13796', '13807', '13808', '13810', '13820', '13825', '13834', '13849', '13859', '13861', '13124', '13129', '13136', '13155', '13332', '13411', '13460', '13733', '13758', '13778', '13780', '13801', '13809', '13814', '13815', '13830', '13832', '13841', '13843', '13844');

    
    
}
