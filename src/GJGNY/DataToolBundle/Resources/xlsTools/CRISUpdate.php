<?php

namespace GJGNY\DataToolBundle\Resources\xlsTools;

use \PHPExcel;

/**
 */
class CRISUpdate extends BasicLeadUpload
{    
    public function __construct($filename, $admin, $leadRepository)
    {
        parent::__construct($filename, $admin, $leadRepository);
    
        $this->fieldPairsToCheckForDuplicates[] = array(
                'FirstName' => 'getFirstName',
                'LastName' => 'getLastName',
                'Zip' => 'getNormalZip'
        );     
    }        
    
    public function processRow($row)
    {
        if($this->checkForDuplicates($row)) {
            $Lead = $this->checkForDuplicates($row);
            $Lead->setCRISStatus($this->getCRISStatus($row));
            $this->updateObject($Lead);                
            $this->updates[] = $this->getFirstName($row).' '.$this->getLastName($row).' (match found : '.$Lead->getFirstName().' '.$Lead->getLastName().')';
        } else {
            $Lead = $this->createLead();
            $Lead = $this->setBasicFields($Lead, $row);
            $Lead = $this->setExtraFields($Lead, $row);
            $this->createObject($Lead);
            $this->insertions[] = $this->getFirstName($row).' '.$this->getLastName($row);
        }
    }
    
    public function setExtraFields($Lead, $row)
    {
        $Lead->setCRISStatus($this->getCRISStatus($row));
        $Lead->setLeadTypeUpgrade(true);
        $Lead->setSourceOfLead('CRIS Database');
        $Lead->setDateOfLead(null);
        
        $normalZip = $this->getNormalZip($row);
        if(in_array($normalZip, $this->tompkinsZips)) {
            $Lead->setDataCounty('Tompkins');            
        } else if(in_array($normalZip, $this->broomeZips)) {
            $Lead->setDataCounty('Broome');            
        }
        
        return $Lead;
    }
    
    protected function getCRISStatus($row)
    {
        return $this->getVal('K' . $row);
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
        return $this->getVal('I' . $row);
    }

    protected function getPrimaryPhoneType($row)
    {
        return null;
    }

    protected function getSecondaryPhone($row)
    {
        return $this->getVal('J' . $row);
    }

    protected function getSecondaryPhoneType($row)
    {
        if($this->getSecondaryPhone($row)) {
            return 'cell';
        } else {
            return null;
        }
        
    }
    
    protected function getNormalZip($row)
    {
        $zipParts = explode('-', $this->getZip($row));
        return $zipParts[0];
    }

    protected function getPersonalEmail($row)
    {
        return $this->getVal('H' . $row);
    }
    
    protected function getWorkEmail($row)
    {
        return null;
    } 
    
    protected $tompkinsZips = array('13053', '13062', '13068', '13073', '13102', '14817', '14850', '14851', '14852', '14853', '14854', '14867', '14881', '14882', '14886', '14814', '14816', '14825', '14838', '14844', '14845', '14861', '14854', '14871', '14872', '14889', '12894', '14901', '14902', '14903', '14904', '14905', '14925', '14805', '14812', '14818', '14824', '14841', '14863', '14865', '14869', '14876', '14887', '14891', '14893', '14529', '14572', '14801', '14807', '14808', '14809', '14810', '14815', '14819', '14820', '14821', '14823', '14826', '14827', '14830', '14831', '14839', '14840', '14843', '14855', '14856', '14858', '14870', '14873', '14874', '14877', '14879', '14885', '14898');
    protected $broomeZips = array('13737', '13744', '13745', '13746', '13748', '13749', '13754', '13760', '13761', '13762', '13763', '13777', '13787', '13790', '13794', '13795', '13797', '13802', '13813', '13826', '13833', '13848', '13850', '13851', '13862', '13865', '13901', '13902', '13903', '13904', '13905', '13732', '13734', '13736', '13743', '13811', '13812', '13827', '13835', '13840', '13845', '13864', '14859', '14883', '14892', '12064', '12116', '12155', '12197', '13315', '13320', '13326', '13333', '13335', '13337', '13342', '13348', '13415', '13429', '13450', '13457', '13468', '13482', '13485', '13488', '13747', '13776', '13796', '13807', '13808', '13810', '13820', '13825', '13834', '13849', '13859', '13861', '13124', '13129', '13136', '13155', '13332', '13411', '13460', '13733', '13758', '13778', '13780', '13801', '13809', '13814', '13815', '13830', '13832', '13841', '13843', '13844');
        
}
