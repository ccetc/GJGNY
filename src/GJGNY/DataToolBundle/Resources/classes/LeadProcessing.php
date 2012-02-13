<?php

namespace GJGNY\DataToolBundle\Resources\classes;

class LeadProcessing {

    public function checkForLeadsToCall ($entityManager, $leadRepository)
    {
        $leadsToUpdate = $leadRepository->findBy(array("DateOfNextFollowup" => date("Y-m-d")));

        foreach($leadsToUpdate as $Lead)
        {
            $Lead->setNeedToCall(true);
            $entityManager->persist($Lead);
        }
        $entityManager->flush();
        
        return count($leadsToUpdate);
    }
    
}

