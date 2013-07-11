<?php

namespace GJGNY\DataToolBundle\Resources\classes;

class LeadProcessing {

    protected $notifications;
    protected $mailer;
    protected $leadRepository;
    protected $userRepository;
    protected $entityManager;
    protected $leadAdmin;
    protected $fromEmail;

    public function __construct($mailer, $entityManager, $leadRepository, $userRepository, $leadAdmin, $fromEmail)
    {
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
        $this->leadRepository = $leadRepository;
        $this->entityManager = $entityManager;
        $this->leadAdmin = $leadAdmin;
        $this->fromEmail = $fromEmail;
        $this->notifications = array();
    }
    
    public function checkForLeadsToCall()
    {
        $leadsToUpdate = $this->leadRepository->findBy(array("DateOfNextFollowup" => new \DateTime()));
        
        foreach($leadsToUpdate as $Lead)
        {
            $Lead->setNeedToCall(true);
            $this->entityManager->persist($Lead);
            
            $this->addNotification($Lead);
        }
        $this->entityManager->flush();
        
        $this->sendNotifications();
        
        return count($leadsToUpdate);
    }
    
    /**
     * If assigned to a user, add Lead to notifcations array using that user's email as a key
     * @param type $lead 
     */
    protected function addNotification($Lead)
    {
        if($Lead->getUserAssignedTo()) {
            $user = $Lead->getUserAssignedTo();

            if(!isset($this->notifications[$user->getEmail()])) {
                $this->notifications[$user->getEmail()] = array('user' => $user, 'leads' => array());
            }

            $this->notifications[$user->getEmail()]['leads'][] = $Lead;    
        }
    }
    
    protected function sendNotifications()
    {
        foreach($this->notifications as $userEmail => $values)
        {
            $this->sendNotificationEmail($userEmail, $this->fromEmail, $values);
        }
    }
            
    protected function sendNotificationEmail($toAddress, $fromAddress, $values)
    {           
        $listOfNewLeads = "";
        
        foreach($values['leads'] as $lead)
        {
            $listOfNewLeads .= '<a href="http://gjgny.ccext.net'.$this->leadAdmin->generateObjectUrl("show", $lead).'">'.$lead->__toString().'</a><br/>';
        }
        
        $message = \Swift_Message::newInstance()
                ->setSubject('GJGNY Data Tool - New Leads to call')
                ->setFrom($fromAddress)
                ->setTo($toAddress)
                ->setContentType('text/html')
                ->setBody('<html>
               We\'ve added '.count($values['leads']).' Leads to your
               <a href="http://gjgny.ccext.net'.$this->leadAdmin->generateUrl('list', array(
                   'filter[needToCall][value]' => '1',
                   'filter[userAssignedTo][value]' => $values['user']->getId())).'">
                    list of Leads that need to be called</a>.<br/><br/>
               Added today:<br/>
               '.$listOfNewLeads.'<br/>

               ')
        ;
        $this->mailer->send($message);
    }
}

