<?php

namespace GJGNY\DataToolBundle\Resources\xlsTools;

use \PHPExcel;

/**
 */
class lutNewCalls extends SpreadsheetUtilities
{

    public function __construct($filename)
    {
        parent::__construct($filename);
    }

    /**
     * Takes the Dryden Light Up Tomkpins spreadsheet and imports the new calls from the last few columns into the LeadEvents Tables
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
                // get Lead
                $Lead = $leadRepository->findOneBy(array('FirstName' => $this->getFirstName($row), 'LastName' => $this->getLastName($row), 'Address' => $this->getAddress($row)));
                
                // if the date of call is set and the lead is found
                if($Lead && $this->getDateOfCall($row))
                {
                    $this->insertions[] = $this->getFirstName($row).' '.$this->getLastName($row);
                    
                    // create new event for lead
                    $Event = new \GJGNY\DataToolBundle\Entity\LeadEvent();
                    $Event->setDate($this->getDateOfCall($row));
                    $Event->setLead($Lead);
                    $Event->setDescription('Lighten Up Tompkins follow up call 2.0');
                    $Event->setCallNotes($this->getCallNotes($row));
                    $Event->setCallStatus($this->getCallStatus($row));
                    $Event->setCallMadeBy($this->getCallMadeBy($row));
                    $Event->setEventType('phone call');
                    $Event->setDatetimeEntered(new \DateTime());
                    $Event->setEnteredBy($admin);

                    $em->persist($Event);
                    $em->flush();    
                }
                else
                {
                    $this->updates[] = "Lead not found!";
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
        return $this->getVal('B' . $row);
    }

    private function getLastName($row)
    {
        return $this->getVal('C' . $row);
    }

    private function getAddress($row)
    {
        return $this->getVal('D' . $row);
    }

    private function getCallMadeBy($row)
    {
        return $this->getTextVal('AR' . $row);
    }

    private function getDateOfCall($row)
    {
        if($this->getDateVal('AQ' . $row))
        {
            return new \DateTime($this->getDateVal('AQ' . $row));
        }
        else
            return false;
    }

    private function getCallNotes($row)
    {
        return $this->getTextVal('AT' . $row);
    }
    private function getCallStatus($row)
    {
        if($this->getTextVal('AS' . $row) == 'Y') return 'answered and spoke';
        else return 'no answer, no machine';
    }

}