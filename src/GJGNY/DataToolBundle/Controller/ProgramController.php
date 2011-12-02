<?php

namespace GJGNY\DataToolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProgramController extends Controller
{

    public function getProgramDateAction($id)
    {
        $programRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:Program');

        $program = $programRepository->findOneById($id);

        if($program->getDate()) {
            $response = $program->getDate()->format('m/d/Y');
        } else {
            $response = "";
        }
        
        return new \Symfony\Component\HttpFoundation\Response($response);
    }

}