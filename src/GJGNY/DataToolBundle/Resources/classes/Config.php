<?php

namespace GJGNY\DataToolBundle\Resources\classes;

class Config
{
    public $admins = array();
    public $notificationEmails = array();

    public function __construct($admins, $notificationEmails = array())
    {
        foreach($admins as $county => $email) {
            $this->admins[$county] = $email;
        }

        print_r($notificationEmails);
        
        foreach($notificationEmails as $county => $emails) {
            $this->notificationEmails[$county] = array();
            
            foreach($emails as $email) {
                $this->notificationEmails[$county][] = $email;
            }
        }
    }

}