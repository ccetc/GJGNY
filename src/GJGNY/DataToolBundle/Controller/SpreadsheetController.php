<?php

namespace GJGNY\DataToolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GJGNY\DataToolBundle\Resources\xlsTools;

class SpreadsheetController extends Controller
{

    public function XLSToDBAction($filename)
    {
        $entityManager = $this->getDoctrine()->getEntityManager();
        $leadRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:Lead');

        switch($filename) {
            case 'GreenBackA':
            case 'GreenBackB':
            case 'GreenBackC':
                $programRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:Program');
                $spreadsheet = new xlsTools\GreenBack('xls/' . $filename . '.xls', $entityManager, $leadRepository, $programRepository, $filename);
                $spreadsheet->processRows();
                break;
            default:
                break;
        }
        
        $templateParameters = array();
        
        if(isset($spreadsheet)) {
            $templateParameters['insertions'] = $spreadsheet->insertions;
            $templateParameters['updates'] = $spreadsheet->updates;
            $templateParameters['deletions'] = $spreadsheet->deletions;
            $templateParameters['duplicates'] = $spreadsheet->duplicates;
        }

        return $this->render('GJGNYDataToolBundle:Spreadsheets:results.html.twig', $templateParameters);
    }

}