<?php

namespace GJGNY\DataToolBundle\Resources\xlsTools;

use \PHPExcel;

/**
 */
class LUT extends SpreadsheetUtilities
{

  public function __construct($filename)
  {
    parent::__construct($filename);
  }
  /**
   * Takes the Dryden Light Up Tomkpins spreadsheet and imports the data into the Lead and LeadEvents Tables
   * 
   * 
   *
   */
  public function xlsToDB($leadRepository, $leadEventRepository, $userRepository, $em)
  {

    $admin = $userRepository->findOneByEmail('scl36@cornell.edu');

    $row = 2;
    $atAnEmptyRow = false;
    while(!$atAnEmptyRow)
    {
      if($this->rowIsEmpty($row))
      {
        $atAnEmptyRow = true;
      }
      else
      {
        // create Lead
        $this->insertions[] = $this->getFirstName($row) . ' ' . $this->getLastName($row);
        $Lead = new \GJGNY\DataToolBundle\Entity\Lead();
        $Lead->setFirstName($this->getFirstName($row));
        $Lead->setLastName($this->getLastName($row));
        $Lead->setAddress($this->getAddress($row));
        $Lead->setCity($this->getCity($row));
        $Lead->setZip($this->getZip($row));
        $Lead->setPhone($this->getPhone($row));
        $Lead->setPersonalEmail($this->getEmail($row));
        $Lead->setTown($this->getTown($row));
        $Lead->setOtherNotes($this->getNotes($row));
        $Lead->setState('NY');
        $Lead->setSourceOfLead('Lighten Up Tomkpins');
        $Lead->setDateOfLead(new \DateTime('11/1/2010'));


        if($this->getNewsletterEnergyTips($row))
          $Lead->setNewsletterChoiceEnergyTips($this->makeStringBool($this->getNewsletterEnergyTips($row)));
        
        if($this->getNewsletterEvents($row))
          $Lead->setNewsletterChoiceEvents($this->makeStringBool($this->getNewsletterEvents($row)));
        
        if($this->getNewsletterSavings($row))
          $Lead->setNewsletterChoiceSavings($this->makeStringBool($this->getNewsletterSavings($row)));
        
        if($this->getCampaignHelp($row) == 'yes')
        {
          $Lead->setCampaignChoiceAppearInVideo(true);
          $Lead->setCampaignChoiceFormEnergyTeam(true);
          $Lead->setCampaignChoiceTalkingToNeighbors(true);
        }
        
        if($this->getShareExperience($row))
        {
          $Lead->setCampaignChoiceShareExperience($this->makeStringBool($this->getShareExperience($row)));
        }
        
        $Lead->setDatetimeEntered(new \DateTime());
        $Lead->setDatetimeLastUpdated(new \DateTime());
        $Lead->setEnteredBy($admin);
        $Lead->setLastUpdatedBy($admin);
        if($this->getAssessmentDone($row)) $Lead->setStep2dCompleted($this->makeStringBool($this->getAssessmentDone($row)));
        if($this->getAssessmentInterest($row)) $Lead->setStep2aInterested($this->makeStringBool($this->getAssessmentInterest($row)));
          
        $em->persist($Lead);
        $em->flush();

        // create LeadEvent for LUT card
        $this->updates[] = 'card';
                
        $CardEvent = new \GJGNY\DataToolBundle\Entity\LeadEvent();
        $CardEvent->setDate(new \DateTime('11/1/2010'));
        $CardEvent->setLead($Lead);
        $CardEvent->setDescription('Lighten Up Tompkins Pledge Card filled out');

        $CardEvent->setDatetimeEntered(new \DateTime());
        $CardEvent->setDatetimeLastUpdated(new \DateTime());
        $CardEvent->setEnteredBy($admin);
        $CardEvent->setLastUpdatedBy($admin);

        $CardEvent->setEventTypeOther('raffle');
        
        $em->persist($CardEvent);
        $em->flush();
        
        // create LeadEvent for letters sent
        if($this->getLetterSentDate($row))
        {
          $this->updates[] = 'letter';
        
          $LetterEvent = new \GJGNY\DataToolBundle\Entity\LeadEvent();
          $LetterEvent->setDate($this->getLetterSentDate($row));
          $LetterEvent->setLead($Lead);
          $LetterEvent->setDescription('GJGNY letter sent');

          $LetterEvent->setDatetimeEntered(new \DateTime());
          $LetterEvent->setDatetimeLastUpdated(new \DateTime());
          $LetterEvent->setEnteredBy($admin);
          $LetterEvent->setLastUpdatedBy($admin);

          $LetterEvent->setEventTypeOther('letter');
          
          $em->persist($LetterEvent);
          $em->flush();
        }

        // create LeadEvent for LUT phone survey
        if($this->getCallMadeBy($row))
        {
          $this->updates[] = 'phone call';
        
          $PhoneEvent = new \GJGNY\DataToolBundle\Entity\LeadEvent();
          if($this->getCallDate($row))
          {
            $PhoneEvent->setDate($this->getCallDate($row));
          }
          $PhoneEvent->setLead($Lead);
          $PhoneEvent->setDescription('Lighten Up Tompkins follow up phone call');
          $PhoneEvent->setCallMadeBy($this->getCallMadeBy($row));
          $PhoneEvent->setEventType('phone call');
        
          
          if($this->getFollowupItems($row)) $PhoneEvent->setFollowUpItems($this->getFollowupItems($row));
          if($this->getActionsTaken($row)) $PhoneEvent->setActionsTaken($this->getActionsTaken($row));
          if($this->getCallNotes($row))
            $PhoneEvent->setCallNotes($this->getCallNotes($row));
          if($this->getWhatWasDiscussed($row))
            $PhoneEvent->setWhatWasDiscussed($this->getWhatWasDiscussed($row));
          $PhoneEvent->setCallStatus($this->getCallStatus($row));
          
          if($this->getCanWeCallBack($row)) $PhoneEvent->setCanWeCallBack($this->makeStringBool($this->getCanWeCallBack($row)));
          if($this->getScrewInBulb($row)) $PhoneEvent->setLutBulb($this->makeStringBool($this->getScrewInBulb($row)));
          if($this->getBulbReplace($row)) $PhoneEvent->setLutBulbReplace($this->makeStringBool($this->getBulbReplace($row)));
          if($this->getCouponMailed($row)) $PhoneEvent->setLutCouponMailed($this->makeStringBool($this->getCouponMailed($row)));
          if($this->getAssessmentDone($row)) $PhoneEvent->setLutAssessment($this->makeStringBool($this->getAssessmentDone($row)));
          if($this->getLookAtMaterials($row)) $PhoneEvent->setLutLookAtMaterials($this->makeStringBool($this->getLookAtMaterials($row)));
          if($this->getMaterialsUseful($row)) $PhoneEvent->setLutMaterialsUseful($this->makeStringBool($this->getMaterialsUseful($row)));
          if($this->getLutNewsletter($row)) $PhoneEvent->setLutNewsletter($this->makeStringBool($this->getLutNewsletter($row)));
          
          $PhoneEvent->setLutCouponType($this->getCouponType($row));
          if($this->getBarriers($row))
            $PhoneEvent->setLutBarriers($this->getBarriers($row));
          if($this->getLutQuestions($row))
            $PhoneEvent->setLutQuestions($this->getLutQuestions($row));
          $PhoneEvent->setLutRentOrOwn($this->getRentOrOwn($row));
          if($this->getStepsTaken($row))
            $PhoneEvent->setLutStepsTaken($this->getStepsTaken($row));
          if($this->getStepsTakenGeneral($row))
            $PhoneEvent->setLutStepsTakenGeneral($this->getStepsTakenGeneral($row));
          if($this->getSupport($row))
            $PhoneEvent->setLutSupport($this->getSupport($row));

          $PhoneEvent->setDatetimeEntered(new \DateTime());
          $PhoneEvent->setDatetimeLastUpdated(new \DateTime());
          $PhoneEvent->setEnteredBy($admin);
          $PhoneEvent->setLastUpdatedBy($admin);

          $em->persist($PhoneEvent);
          $em->flush();
        }
      }

      $row++;
    }
  }

  private function rowIsEmpty($row)
  {
    return trim($this->getVal('A' . $row)) == '';
  }

  private function getFirstName($row)
  {
    return $this->getVal('A' . $row);
  }

  private function getLastName($row)
  {
    return $this->getVal('B' . $row);
  }

  private function getAddress($row)
  {
    return $this->getVal('C' . $row);
  }

  private function getCity($row)
  {
    return $this->getVal('D' . $row);
  }

  private function getZip($row)
  {
    return $this->getVal('E' . $row);
  }

  private function getPhone($row)
  {
    return $this->getVal('F' . $row);
  }

  private function getEmail($row)
  {
    return $this->getVal('G' . $row);
  }

  private function getTown($row)
  {
    return $this->getVal('M' . $row);
  }

  private function getNotes($row)
  {
    return $this->getVal('O' . $row);
  }

  private function getLetterSentDate($row)
  {
    if($this->getDateVal('N' . $row))
    {
      return new \DateTime($this->getDateVal('N' . $row));
    }
    else
      return false;
  }

  private function getNewsletterEnergyTips($row)
  {
    return $this->getBoolVal('H' . $row);
  }

  private function getNewsletterEvents($row)
  {
    return $this->getBoolVal('I' . $row);
  }

  private function getNewsletterSavings($row)
  {
    return $this->getBoolVal('J' . $row);
  }

  private function getCampaignHelp($row)
  {
    return $this->getBoolVal('L' . $row);
  }

  private function getShareExperience($row)
  {
    return $this->getBoolVal('K' . $row);
  }

  private function getCallMadeBy($row)
  {
    return $this->getTextVal('P' . $row);
  }

  private function getCallDate($row)
  {
    if($this->getDateVal('Q' . $row))
    {
      return new \DateTime($this->getDateVal('Q' . $row));
    }
    else
      return false;
  }

  private function getCanWeCallBack($row)
  {
    return $this->getBoolVal('AL' . $row);
  }

  private function getScrewInBulb($row)
  {
    return $this->getBoolVal('Z' . $row);
  }

  private function getBulbReplace($row)
  {
    return $this->getBoolVal('AA' . $row);
  }

  private function getAssessmentDone($row)
  {
    return $this->getBoolVal('AH' . $row);
  }

  private function getAssessmentInterest($row)
  {
    return $this->getBoolVal('AP' . $row);
  }

  private function getLookAtMaterials($row)
  {
    return $this->getBoolVal('AB' . $row);
  }

  private function getMaterialsUseful($row)
  {
    return $this->getBoolVal('AC' . $row);
  }

  private function getLutNewsletter($row)
  {
    return $this->getBoolVal('AJ' . $row);
  }

  private function getCallNotes($row)
  {
    // use the call status column
    return $this->getTextVal('R' . $row);
  }

  private function getWhatWasDiscussed($row)
  {
    // use the notes column that I made
    return $this->getTextVal('AQ' . $row);
  }
  
  private function getBarriers($row)
  {
    return $this->getTextVal('AG' . $row);
  }

  private function getLutQuestions($row)
  {
    return $this->getTextVal('AK' . $row);
  }

  private function getStepsTaken($row)
  {
    return $this->getTextVal('AD' . $row);
  }

  private function getStepsTakenGeneral($row)
  {
    return $this->getTextVal('AE' . $row);
  }

  private function getSupport($row)
  {
    return $this->getTextVal('AI' . $row);
  }

  private function getFollowupItems($row)
  {
    return $this->getTextVal('AO' . $row);
  }
  
  private function getActionsTaken($row)
  {
    return $this->getTextVal('AN' . $row);
  }

  private function getCouponMailed($row)
  {
    // if the value is something beside blank, and isn't no, then it was mailed
    $val = $this->getTextVal('AM'.$row);
    if($val && $val != 'no')
      return true;
    else return false;
  }
  
  private function getCouponType($row)
  {
    // if the value is something beside blank, yes, or no, then it is the type 
    $val = $this->getTextVal('AM'.$row);
    if($val && $val != 'no' && $val != 'yes')
      return $val;
    else return false;
  }
  
  private function getRentOrOwn($row)
  {
    $val = $this->getTextVal('AF' . $row);
    
    if($val == 'rent' || $val == 'Rent') return 'rent';
    else if($val == 'own' || $val == 'Own') return 'own';
  }

  private function getCallStatus($row)
  {
    if($this->getBoolVal('S'.$row))
    {
      return 'answered and spoke';
    }
    else if($this->getBoolVal('T'.$row))
    {
      return 'answered and declined';
    }
    else if($this->getBoolVal('U'.$row))
    {
      return 'left message';
    }
    else if($this->getBoolVal('V'.$row))
    {
      return 'no answer, no machine';
    }
    else if($this->getBoolVal('W'.$row))
    {
      return 'wrong number / missing number';
    }
  }
}