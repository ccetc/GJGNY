<?php

namespace GJGNY\DataToolBundle\Resources\xlsTools;

use \PHPExcel;

/**
 */
class SummerContacts extends SpreadsheetUtilities
{

    public function __construct($filename)
    {
        parent::__construct($filename);
    }

    /**
     * Takes the Summer Contacts spreadsheet and imports the data into the Lead and LeadEvents Tables
     */
    public function xlsToDB($leadRepository, $leadEventRepository, $userRepository, $em)
    {

//    $admin = $userRepository->findOneByEmail('scl36@cornell.edu');
        $admin = $userRepository->findOneByEmail('haggertypat@gmail.com');

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
                $Lead->setDataCounty('Tompkins');
                
                $Lead->setFirstName($this->getFirstName($row));
                $Lead->setLastName($this->getLastName($row));
                $Lead->setAddress($this->getAddress($row));
                $Lead->setCity($this->getCity($row));
                $Lead->setZip($this->getZip($row));
                $Lead->setPhone($this->getPhone($row));
                $Lead->setPersonalEmail($this->getEmail($row));
                $Lead->setOtherNotes($this->getNotes($row));
                $Lead->setState('NY');
                $Lead->setProgramSource($this->getProgramSource($row));
                $Lead->setSourceOfLead('tabling');
                if($this->getDateOfPledge($row)) $Lead->setDateOfLead($this->getDateOfPledge($row));

                if($this->getDateTimeEntered($row)) $Lead->setDatetimeEntered($this->getDateTimeEntered($row));
                if($this->getDateTimeEntered($row)) $Lead->setDatetimeLastUpdated($this->getDateTimeEntered($row));
                $Lead->setEnteredBy($admin);
                $Lead->setLastUpdatedBy($admin);

                if($this->getShareExperience($row))
                    $Lead->setCampaignChoiceShareExperience(true);

                if($this->getRaffle($row))
                    $Lead->setOctober2011Raffle(true);

                $Lead->setBarriers($this->getBarriers($row));
                

                if($this->getInterestedInVisit($row))
                    $Lead->setInterestedInVisit(true);
                if($this->getNewsletterEnergyTips($row))
                    $Lead->setNewsletterChoiceEnergyTips(true);
                if($this->getNewsletterEvents($row))
                    $Lead->setNewsletterChoiceEvents(true);
                if($this->getNewsletterSavings($row))
                    $Lead->setNewsletterChoiceSavings(true);
                if($this->getFormEnergyTeam($row))
                    $Lead->setCampaignChoiceFormEnergyTeam(true);
                
                if($this->getMonthlyEmail($row))
                {
                    if($this->getMonthlyEmail($row) == 'yes')
                    {
                        $Lead->setNewsletterChoiceEnergyTips(true);
                        $Lead->setNewsletterChoiceSavings(true);
                        $Lead->setNewsletterChoiceEvents(true);
                    }
                    else
                    {
                        $Lead->setNewsletterChoiceEnergyTips(false);
                        $Lead->setNewsletterChoiceSavings(false);
                        $Lead->setNewsletterChoiceEvents(false);                        
                    }
                }

                if(!$this->getCallDateTime($row)) $Lead->setLeadStatus('need to call');

                $em->persist($Lead);
                $em->flush();
                
                // event
                if($this->getCallDateTime($row))
                {
                    $this->updates[] = 'call';

                    $CallEvent = new \GJGNY\DataToolBundle\Entity\LeadEvent();
                    $CallEvent->setDate($this->getCallDateTime($row));
                    $CallEvent->setLead($Lead);
                    $CallEvent->setDescription('follow up call');

                    $CallEvent->setDatetimeEntered(new \DateTime());
                    $CallEvent->setDatetimeLastUpdated(new \DateTime());
                    $CallEvent->setEnteredBy($admin);
                    $CallEvent->setLastUpdatedBy($admin);

                    $CallEvent->setEventType('phone call');

                    if($this->getCallBack($row))
                    {
                        if($this->getCallBack($row) == 'yes') $CallEvent->setCanWeCallBack(true);
                        else $CallEvent->setCanWeCallBack(false);
                    }


                    $CallEvent->setCallStatus($this->getCallStatus($row));

                    $CallEvent->setCallNotes($this->getCallNotes($row));
                    
                    $em->persist($CallEvent);
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
        return $this->getVal('E' . $row);
    }

    private function getLastName($row)
    {
        return $this->getVal('F' . $row);
    }

    private function getAddress($row)
    {
        return $this->getVal('G' . $row);
    }

    private function getCity($row)
    {
        return $this->getVal('H' . $row);
    }

    private function getZip($row)
    {
        return $this->getVal('I' . $row);
    }

    private function getPhone($row)
    {
        return $this->getVal('J' . $row);
    }

    private function getEmail($row)
    {
        return $this->getVal('K' . $row);
    }

    private function getNotes($row)
    {
        return $this->getVal('P' . $row);
    }

    private function getProgramSource($row)
    {
        return $this->getVal('D' . $row);
    }

    private function getDateOfPledge($row)
    {
        if($this->getDateTimeVal('C' . $row))
        {
            return new \DateTime($this->getDateTimeVal('C' . $row));
        }
        else
            return false;
    }

    private function getDateTimeEntered($row)
    {
        if($this->getDateTimeVal('A' . $row))
        {
            return new \DateTime($this->getDateTimeVal('A' . $row));
        }
        else
            return false;
    }

    private function getShareExperience($row)
    {
        if($this->getTextVal('M' . $row) == "Yes, I've made major energy upgrades to my home and would be willing to share my experience with others")
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function getRaffle($row)
    {
        if($this->getTextVal('O' . $row) == "Yes! Enter me in the prize raffle")
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function getInterestedInVisit($row)
    {
        if(strstr($this->getTextVal('L' . $row), "Scheduling a home energy visit"))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function getNewsletterEnergyTips($row)
    {
        if(strstr($this->getTextVal('L' . $row), "How-to tips on saving energy and money"))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function getNewsletterEvents($row)
    {
        if(strstr($this->getTextVal('L' . $row), "Invitations to events and workshops"))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function getNewsletterSavings($row)
    {
        if(strstr($this->getTextVal('L' . $row), "Energy-saving programs and incentives I may qualify for"))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function getFormEnergyTeam($row)
    {
        if(strstr($this->getTextVal('L' . $row), "Joining an energy team"))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function getCallDateTime($row)
    {
        if($this->getDateTimeVal('R' . $row))
        {
            return new \DateTime($this->getDateTimeVal('R' . $row));
        }
        else
            return false;
    }

    private function getCallStatus($row)
    {
        return $this->getVal('S' . $row);
    }

    private function getBarriers($row)
    {
        return $this->getVal('W' . $row);
    }
    
    private function getCallNotes($row)
    {
        return $this->getVal('AA' . $row);
    }

    private function getMonthlyEmail($row)
    {
        return $this->getBoolVal('Y' . $row);
    }

    private function getCallBack($row)
    {
        return $this->getBoolVal('Z' . $row);
    }

    
}