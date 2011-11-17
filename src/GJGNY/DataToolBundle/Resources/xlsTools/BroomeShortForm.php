<?php

namespace GJGNY\DataToolBundle\Resources\xlsTools;

use \PHPExcel;

/**
 */
class BroomeShortForm extends SpreadsheetUtilities
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
                $Lead->setOrganization($this->getOrganization($row));

                $Lead->setPersonalEmail($this->getPersonalEmail($row));

                $Lead->setOtherNotes($this->getOtherNotes($row));

//              $Lead->setDateOfLead(new \DateTime('11/1/2010'));
                $Lead->setSourceOfLeadOther("Energy Leadership Program");
                $Lead->setLeadReferral($this->getLeadReferral($row));

                $Lead->setCommunityGroupsConnectedTo($this->getCommunityGroupsConnectedTo($row));

                $Lead->setPledge($this->getPledge($row));

                $Lead->setDatetimeEntered(new \DateTime());
                $Lead->setDatetimeLastUpdated(new \DateTime());
                $Lead->setEnteredBy($admin);
                $Lead->setLastUpdatedBy($admin);

                $Lead->setDataCounty("Broome");

                $Lead->setBECCTeam($this->getBECCTeam($row));
                $Lead->setVisitPeriod($this->getVisitPeriod($row));

                $em->persist($Lead);
                $em->flush();

                if($this->getInvitationSentDate($row))
                {
                    $InvitationSent = new \GJGNY\DataToolBundle\Entity\LeadEvent();
                    $InvitationSent->setDate($this->getInvitationSentDate($row));
                    $InvitationSent->setLead($Lead);
                    $InvitationSent->setEventType("generic");
                    $InvitationSent->setDescription("Invitation Sent");

                    $InvitationSent->setContactPerson($this->getInvitationSentBy($row));
                    $InvitationSent->setNotes($this->getInvitationSentNotes($row));

                    $InvitationSent->setDatetimeEntered(new \DateTime());
                    $InvitationSent->setDatetimeLastUpdated(new \DateTime());
                    $InvitationSent->setEnteredBy($admin);
                    $InvitationSent->setLastUpdatedBy($admin);

                    $em->persist($InvitationSent);
                    $em->flush();
                }

                if($this->getInitialVisitDateTime($row))
                {
                    $InitialVisit = new \GJGNY\DataToolBundle\Entity\LeadEvent();
                    $InitialVisit->setDate($this->getInitialVisitDateTime($row));
                    $InitialVisit->setLead($Lead);
                    $InitialVisit->setEventType("in person");
                    $InitialVisit->setDescription("Initial Visit");

                    $InitialVisit->setNotes($this->getInitialVisitNotes($row));

                    $InitialVisit->setDatetimeEntered(new \DateTime());
                    $InitialVisit->setDatetimeLastUpdated(new \DateTime());
                    $InitialVisit->setEnteredBy($admin);
                    $InitialVisit->setLastUpdatedBy($admin);

                    $em->persist($InitialVisit);
                    $em->flush();
                }

                if($this->getFollowUpVisitDateTime($row))
                {
                    $FollowUpVisit = new \GJGNY\DataToolBundle\Entity\LeadEvent();
                    $FollowUpVisit->setDate($this->getFollowUpVisitDateTime($row));
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
                
                if($this->getAdditionalFollowUpDate($row))
                {
                    $FollowUp = new \GJGNY\DataToolBundle\Entity\LeadEvent();
                    $FollowUp->setDate($this->getAdditionalFollowUpDate($row));
                    $FollowUp->setLead($Lead);
                    $FollowUp->setEventType("e-mail");
                    $FollowUp->setDescription($this->getAdditionalFollowUpDescription($row));
                    $FollowUp->setNotes($this->getAdditionalFollowUpNotes($row));
                    $FollowUp->setContactPerson($this->getAdditionalFollowUpBy($row));
                    
                    $FollowUp->setDatetimeEntered(new \DateTime());
                    $FollowUp->setDatetimeLastUpdated(new \DateTime());
                    $FollowUp->setEnteredBy($admin);
                    $FollowUp->setLastUpdatedBy($admin);

                    $em->persist($FollowUp);
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
        return $this->getVal('C' . $row);
    }

    private function getLastName($row)
    {
        return $this->getVal('E' . $row);
    }

    private function getMiddleInitial($row)
    {
        return $this->getVal('D' . $row);
    }

    private function getAddress($row)
    {
        return $this->getVal('L' . $row);
    }

    private function getCity($row)
    {
        return $this->getVal('M' . $row);
    }

    private function getState($row)
    {
        return 'NY';
    }

    private function getZip($row)
    {
        return $this->getVal('N' . $row);
    }

    private function getCounty($row)
    {
        return "Broome";
    }

    private function getPhone($row)
    {
        return $this->getVal('H' . $row);
    }

    private function getPrimaryPhoneType($row)
    {
        return $this->getVal('I' . $row);
    }

    private function getSecondaryPhone($row)
    {
        return $this->getVal('J' . $row);
    }

    private function getSecondaryPhoneType($row)
    {
        return $this->getVal('K' . $row);
    }

    private function getOrganization($row)
    {
        return $this->getVal('B' . $row);
    }

    private function getOrgTitle($row)
    {
        return $this->getVal('F' . $row);
    }

    private function getPersonalEmail($row)
    {
        return $this->getVal('G' . $row);
    }

    private function getOtherNotes($row)
    {
        return $this->getVal('AF' . $row);
    }

    private function getLeadReferral($row)
    {
        return $this->getVal('O' . $row);
    }

    private function getPledge($row)
    {
        return $this->getVal('AD' . $row);
    }

    private function getCommunityGroupsConnectedTo($row)
    {
        return $this->getVal('AE' . $row);
    }

    private function getBECCTeam($row)
    {
        return $this->getVal('T' . $row);
    }

    private function getVisitPeriod($row)
    {
        return $this->getVal('A' . $row);
    }

    private function getInvitationSentDate($row)
    {
        if($this->getDateVal('P' . $row))
        {
            return new \DateTime($this->getDateVal('P' . $row));        
        }
        else
        {
            return false;
        }
    }

    private function getInvitationSentBy($row)
    {
        return $this->getVal('Q' . $row);
    }

    private function getInvitationSentNotes($row)
    {
        return $this->getVal('R' . $row);
    }

    private function getInitialVisitDateTime($row)
    {
        if($this->getDateVal('U' . $row))
        {
            return new \DateTime($this->getDateVal('U' . $row) . ' ' . $this->getTimeVal('V' . $row));
        }
        else
        {
            return false;
        }
    }

    private function getInitialVisitNotes($row)
    {
        return $this->getVal('W' . $row);
    }

    private function getFollowUpVisitDateTime($row)
    {
        if($this->getDateTimeVal('X' . $row))
        {
            return new \DateTime($this->getDateTimeVal('X' . $row));        
        }
        else
        {
            return false;
        }
    }
    
    private function getAdditionalFollowUpDate($row)
    {
        if($this->getDateVal('Y' . $row))
        {
            return new \DateTime($this->getDateVal('Y' . $row));        
        }
        else
        {
            return false;
        }
    }
    private function getAdditionalFollowUpNotes($row)
    {
        return $this->getVal('AB' . $row);
    }
    private function getAdditionalFollowUpBy($row)
    {
        return $this->getVal('Z' . $row);
    }
    private function getAdditionalFollowUpDescription($row)
    {
        return $this->getVal('AA' . $row);
    }

}
