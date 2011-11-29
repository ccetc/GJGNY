<?php

namespace GJGNY\DataToolBundle\Resources\classes;

class EmailDigest
{

    public function getLeadsToCallAndSendEmails($leadRepository, $emailAddresses, $mailer, $fromAddress)
    {
        $leadsToCall = $leadRepository->findBy(array("leadStatus" => "need to call"));

        $BroomeLeadCount = 0;

        $TompkinsLeadCount = 0;

        foreach($leadsToCall as $Lead)
        {
            if($Lead->getDataCounty() == "Broome")
            {
                $BroomeLeadCount++;
            }
            else if($Lead->getDataCounty() == "Tompkins")
            {
                $TompkinsLeadCount++;
            }
        }
        
        if($BroomeLeadCount > 0) {
            foreach($emailAddresses['Broome'] as $toAddress) {
                $this->sendLeadsToCallEmail($mailer, $toAddress, $fromAddress, $BroomeLeadCount, 'Broome' );
            }
        }
        if($TompkinsLeadCount > 0) {
            foreach($emailAddresses['Tompkins'] as $toAddress) {
                $this->sendLeadsToCallEmail($mailer, $toAddress, $fromAddress, $TompkinsLeadCount, 'Tompkins' );
            }
        }
    }

    private function sendLeadsToCallEmail($mailer, $toAddress, $fromAddress, $count, $county)
    {
        if($count == "1") {
            $noun = "Lead";
            $verb = "is";
            $callVerb = "needs";
            $who = "this lead";
        }
        else
        {
            $noun = "Leads";
            $verb = "are";
            $callVerb = "need";
            $who = "them";
        }
            
        $message = \Swift_Message::newInstance()
                ->setSubject('GJGNY Data Tool - notification digest')
                ->setFrom($fromAddress)
                ->setTo($toAddress)
                ->setContentType('text/html')
                ->setBody('<html>
               There '.$verb.' '.$count.' '.$county.' County '.$noun.' that '.$callVerb.' to be called.<br/><br/>
               To view '.$who.', follow the link below.<br/>
               <a href="http://gjgny.ccext.net/admin/gjgny/datatool/lead/list?leadStatus=need+to+call">http://gjgny.ccext.net/admin/gjgny/datatool/lead/list?leadStatus=need+to+call</a></html>')
        ;
        $mailer->send($message);
    }

}

