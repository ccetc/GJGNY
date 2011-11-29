<?php

namespace GJGNY\DataToolBundle\Resources\classes;

class Config
{
    public $xlsDirectory;
    public $supportEmail;
    public $admins = array();
    public $notificationEmails = array();

    public function __construct($xlsDirectory, $supportEmail, $admins, $notificationEmails = array())
    {
        $this->xlsDirectory = $xlsDirectory;
        $this->supportEmail = $supportEmail;

        foreach($admins as $county => $email) {
            $this->admins[$county] = $email;
        }

        foreach($notificationEmails as $county => $emails) {
            $this->notificationEmails[$county] = array();
            
            foreach($emails as $email) {
                $this->notificationEmails[$county][] = $email;
            }
        }
    }

}