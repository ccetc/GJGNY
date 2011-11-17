<?php

namespace GJGNY\DataToolBundle\Resources\xlsTools;

use \PHPExcel;

/**
 */
class BroomeMaster extends SpreadsheetUtilities
{

    public function __construct($filename)
    {
        parent::__construct($filename);
    }

    /**
     * Takes the "Master Spreadsheet" used in Broome county and imports data to the database
     * 
     * 
     *
     */
    public function xlsToDB($leadRepository, $leadEventRepository, $userRepository, $em)
    {
        $admin = $userRepository->findOneByEmail('flint@igc.org');
        //$admin = $userRepository->findOneByEmail('haggertypat@gmail.com');

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
                $Lead->setLeadType('energy upgrade');
                $Lead->setFirstName($this->getFirstName($row));
                $Lead->setLastName($this->getLastName($row));
                $Lead->setMiddleInitial($this->getMiddleInitial($row));
                $Lead->setAddress($this->getAddress($row));
                $Lead->setCity($this->getCity($row));
                $Lead->setZip($this->getZip($row));
                $Lead->setState($this->getState($row));
                $Lead->setCounty($this->getCounty($row));
                $Lead->setPhone($this->getPhone($row));
                $Lead->setPrimaryPhoneType($this->getPrimaryPhoneType($row));
                $Lead->setSecondaryPhone($this->getSecondaryPhone($row));
                $Lead->setSecondaryPhoneType($this->getSecondaryPhoneType($row));

                $Lead->setOrgTitle($this->getOrgTitle($row));
                $Lead->setOrgAddress($this->getOrgAddress($row));
                $Lead->setOrgCity($this->getOrgCity($row));
                $Lead->setOrgCounty($this->getOrgCounty($row));
                $Lead->setOrgState($this->getOrgState($row));
                $Lead->setOrgZip($this->getOrgZip($row));
                $Lead->setOrganization($this->getOrganization($row));

                $Lead->setPersonalEmail($this->getPersonalEmail($row));
                $Lead->setWorkEmail($this->getWorkEmail($row));
                $Lead->setWebsite($this->getWebsite($row));

                $Lead->setSqFootage($this->getSqFootage($row));

                $Lead->setRank($this->getRank($row));
                
                $Lead->setOtherNotes($this->getOtherNotes($row));

//              $Lead->setDateOfLead(new \DateTime('11/1/2010'));
                $Lead->setSourceOfLeadOther($this->getSourceOfLead($row));
                $Lead->setLeadReferral($this->getLeadReferral($row));

                $Lead->setCommunityGroupsConnectedTo($this->getCommunityGroupsConnectedTo($row));
                
                $Lead->setPledge($this->getPledge($row));

                $Lead->setDatetimeEntered(new \DateTime());
                $Lead->setDatetimeLastUpdated(new \DateTime());
                $Lead->setEnteredBy($admin);
                $Lead->setLastUpdatedBy($admin);

                $Lead->setDataCounty("Broome");

                if($this->getApplicationSubmitted($row) != null)
                    $Lead->setStep2bSubmitted(true);
                if($this->getAuditPerformed($row) != null)
                    $Lead->setStep2dCompleted(true);

                $em->persist($Lead);
                $em->flush();

                if($this->getHomeEnergyVisitDate($row))
                {
                    $HomeEnergyVisit = new \GJGNY\DataToolBundle\Entity\LeadEvent();
                    $HomeEnergyVisit->setDate($this->getHomeEnergyVisitDate($row));
                    $HomeEnergyVisit->setLead($Lead);
                    $HomeEnergyVisit->setEventType("in person");
                    $HomeEnergyVisit->setDescription("Home Energy Visit");

                    $HomeEnergyVisit->setDatetimeEntered(new \DateTime());
                    $HomeEnergyVisit->setDatetimeLastUpdated(new \DateTime());
                    $HomeEnergyVisit->setEnteredBy($admin);
                    $HomeEnergyVisit->setLastUpdatedBy($admin);

                    $em->persist($HomeEnergyVisit);
                    $em->flush();
                }
                
                if($this->getFollowUpVisitDate($row))
                {
                    $FollowUpVisit = new \GJGNY\DataToolBundle\Entity\LeadEvent();
                    $FollowUpVisit->setDate($this->getFollowUpVisitDate($row));
                    $FollowUpVisit->setLead($Lead);
                    $FollowUpVisit->setEventType("in person");
                    $FollowUpVisit->setDescription("Follow Up Visit");

                    $FollowUpVisit->setDatetimeEntered(new \DateTime());
                    $FollowUpVisit->setDatetimeLastUpdated(new \DateTime());
                    $FollowUpVisit->setEnteredBy($admin);
                    $FollowUpVisit->setLastUpdatedBy($admin);

                    $em->persist($FollowUpVisit);
                    $em->flush();
                }
                
                if($this->getDateOfFollowUpCall($row))
                {
                    $FollowUpCall = new \GJGNY\DataToolBundle\Entity\LeadEvent();
                    $FollowUpCall->setDate($this->getDateOfFollowUpCall($row));
                    $FollowUpCall->setLead($Lead);
                    $FollowUpCall->setEventType("phone call");
                    $FollowUpCall->setDescription("Follow Up Call");

                    $FollowUpCall->setDatetimeEntered(new \DateTime());
                    $FollowUpCall->setDatetimeLastUpdated(new \DateTime());
                    $FollowUpCall->setEnteredBy($admin);
                    $FollowUpCall->setLastUpdatedBy($admin);

                    $em->persist($FollowUpCall);
                    $em->flush();
                }
                
                if($this->getLetterSentDate($row))
                {
                    $LetterSent = new \GJGNY\DataToolBundle\Entity\LeadEvent();
                    $LetterSent->setDate($this->getLetterSentDate($row));
                    $LetterSent->setLead($Lead);
                    $LetterSent->setEventTypeOther("letter");
                    $LetterSent->setDescription("Follow Up Thank You Letter sent");

                    $LetterSent->setDatetimeEntered(new \DateTime());
                    $LetterSent->setDatetimeLastUpdated(new \DateTime());
                    $LetterSent->setEnteredBy($admin);
                    $LetterSent->setLastUpdatedBy($admin);

                    $em->persist($LetterSent);
                    $em->flush();
                }
               
            }

            $row++;
        }
    }

    private function rowIsEmpty($row)
    {
        return trim($this->getVal('C' . $row)) == '' && trim($this->getVal('B' . $row)) == '';
    }

    private function getFirstName($row)
    {
        return $this->getVal('E' . $row);
    }

    private function getLastName($row)
    {
        return $this->getVal('C' . $row);
    }

    private function getMiddleInitial($row)
    {
        return $this->getVal('D' . $row);
    }

    private function getAddress($row)
    {
        return $this->getVal('P' . $row);
    }

    private function getCity($row)
    {
        return $this->getVal('Q' . $row);
    }

    private function getState($row)
    {
        return $this->getVal('R' . $row);
    }

    private function getZip($row)
    {
        return $this->getVal('S' . $row);
    }

    private function getCounty($row)
    {
        return $this->getVal('T' . $row);
    }

    private function getPhone($row)
    {
        return $this->getVal('I' . $row);
    }

    private function getPrimaryPhoneType($row)
    {
        return $this->getVal('J' . $row);
    }

    private function getSecondaryPhone($row)
    {
        return $this->getVal('K' . $row);
    }

    private function getSecondaryPhoneType($row)
    {
        return $this->getVal('L' . $row);
    }

    private function getOrganization($row)
    {
        return $this->getVal('B' . $row);
    }

    private function getOrgTitle($row)
    {
        return $this->getVal('F' . $row);
    }

    private function getOrgAddress($row)
    {
        return $this->getVal('V' . $row);
    }

    private function getOrgCity($row)
    {
        return $this->getVal('W' . $row);
    }

    private function getOrgState($row)
    {
        return $this->getVal('X' . $row);
    }

    private function getOrgZip($row)
    {
        return $this->getVal('Y' . $row);
    }

    private function getOrgCounty($row)
    {
        return $this->getVal('Z' . $row);
    }

    private function getPersonalEmail($row)
    {
        return $this->getVal('H' . $row);
    }

    private function getWorkEmail($row)
    {
        return $this->getVal('G' . $row);
    }

    private function getWebsite($row)
    {
        return $this->getVal('O' . $row);
    }

    private function getSqFootage($row)
    {
        return $this->getVal('U' . $row);
    }

    private function getOtherNotes($row)
    {
        return $this->getVal('AN' . $row);
    }

    private function getLeadReferral($row)
    {
        return $this->getVal('AL' . $row);
    }
    
    private function getPledge($row)
    {
        return $this->getVal('AC' . $row);
    }
    
    private function getRank($row)
    {
        return $this->getVal('A' . $row);
    }
    
    private function getSourceOfLead($row)
    {
        if($this->getVal('B' . $row) == "Citizen Action Summer Interest List")
        {
            return "Citizen Action Summer Interest List";
        }
        else if($this->getVal('AM' . $row) == "John Burns show")
        {
            return "John Burns show";
        }
        else if($this->getVal('AM' . $row) == "Lighten Up Broome Pledge-Senior Picnic")
        {
            return "Lighten Up Broome Pledge Picnic";
        }
        else
        {
            return "Energy Leadership Program";
        }
    }

    private function getCommunityGroupsConnectedTo($row)
    {
        if($this->getVal('AM' . $row) != "Lighten Up Broome Pledge-Senior Picnic" &&
                $this->getVal('AM' . $row) != "Lighten Up Broome Pledge-Senior Picnic")
        {
            return $this->getVal('AM' . $row);
        }
        else
        {
            return "";
        }
    }

    private function getApplicationSubmitted($row)
    {
        return $this->makeStringBool($this->getBoolVal('AG' . $row));
    }

    private function getAuditPerformed($row)
    {
        return $this->makeStringBool($this->getBoolVal('AH' . $row));
    }

    private function getHomeEnergyVisitDate($row)
    {
        if($this->getDateVal('AA' . $row))
        {
            return new \DateTime($this->getDateVal('AA' . $row));
        }
        else
        {
            return false;
        }
    }
    private function getFollowUpVisitDate($row)
    {
        if($this->getDateVal('AB' . $row))
        {
            return new \DateTime($this->getDateVal('AB' . $row));
        }
        else
        {
            return false;
        }
    }
    private function getDateOfFollowUpCall($row)
    {
        if($this->getDateVal('AD' . $row))
        {
            return new \DateTime($this->getDateVal('AD' . $row));
        }
        else
        {
            return false;
        }
    }
    private function getLetterSentDate($row)
    {
        if($this->getDateVal('AF' . $row))
        {
            return new \DateTime($this->getDateVal('AF' . $row));
        }
        else
        {
            return false;
        }
    }
}
