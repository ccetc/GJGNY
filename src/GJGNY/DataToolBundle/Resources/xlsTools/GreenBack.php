<?php

namespace GJGNY\DataToolBundle\Resources\xlsTools;

use \PHPExcel;

/**
 */
class GreenBack extends BasicLeadUpload
{
    
    public $programSource;
    public $programRepository;
    public $sheetName;
    
    public function __construct($filename, $entityManager, $leadRepository, $programRepository, $sheetName)
    {
        $this->programRepository = $programRepository;
        $this->sheetName = $sheetName;
        parent::__construct($filename, $entityManager, $leadRepository);
    }        
    
    public function setExtraFields($Lead, $row)
    {
        switch($this->sheetName) {
            case 'GreenBackA':
                $Lead->setStep2dCompleted(true);
                break;
            case 'GreenBackB':
                $Lead->setStep2aInterested(true);
                $Lead->setOtherNotes('2/27 Sent e-mail (if e-mail address is on file) with link to Upgrade Upstate.  If no e-mail address is listed the lead has not been contacted yet.');
                break;
            case 'GreenBackC':
                $Lead->setStep2aInterested(true);
                $Lead->setUpgradeStatusNotes('Marked "Unsure: Send me more information" on raffle card.');
                $Lead->setOtherNotes('2/27 Sent e-mail (if e-mail address is on file) with link to Upgrade Upstate.  If no e-mail address is listed the lead has not been contacted yet.');
                break;
        }
        $Lead->setDataCounty('Tompkins');
        $Lead->setLeadStatus('active lead');
        $Lead->setDateOfNextFollowup(new \DateTime('3/15/2012'));
        $Lead->setDateOfLead(new \DateTime('10/31/2011'));
        $Lead->setLeadTypeUpgrade(true);
        $Lead->setProgram($this->programRepository->findOneByName('Get Your Greenback Tompkins Into the Streets'));
        
        if($this->getOtherNotes($row)) {
            $Lead->setOtherNotes($Lead->getOtherNotes().' '.$this->getOtherNotes($row));
        }
        
        return $Lead;
    }
    
    public function getOtherNotes($row)
    {
        return $this->getVal('P' . $row);
    }
    
}
