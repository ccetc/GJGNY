<?php

namespace GJGNY\DataToolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SpreadsheetController extends Controller
{

  public function XLSToDBAction($type)
  {
    $leadRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:Lead');
    $leadEventRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:LeadEvent');
    $userRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:User');
    $entityManager = $this->getDoctrine()->getEntityManager();

    switch($type)
    {
      case 'Dryden':
      case 'Tompkins':
        $tool = new \GJGNY\DataToolBundle\Resources\xlsTools\LUT('xls/'.$type.'.xls');
        break;
      default:
        break;
    }
    $tool->xlsToDB($leadRepository, $leadEventRepository, $userRepository, $entityManager);



    return $this->render('GJGNYDataToolBundle:Spreadsheets:results.html.twig', array(
        'insertions' => $tool->insertions,
        'updates' => $tool->updates,
        'deletions' => $tool->deletions,
    ));
  }

}