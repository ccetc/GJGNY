<?php

namespace GJGNY\DataToolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GJGNY\DataToolBundle\Resources\xlsTools;
use Symfony\Component\HttpFoundation\Response;

class SpreadsheetController extends Controller
{

    public function XLSToDBAction($filename)
    {
        ini_set('memory_limit', '1024M');
        set_time_limit ( 0 );

        $entityManager = $this->getDoctrine()->getEntityManager();
        $leadRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:Lead');
        $countyRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:County');
        $leadAdmin = $this->get('gjgny.datatool.admin.lead');        
        
        switch($filename) {
            case 'CRISInfo':
                $spreadsheet = new xlsTools\CRISInfo('xls/' . $filename . '.xls', $leadAdmin, $leadRepository, $countyRepository);
                $spreadsheet->processRows();                
                break;
            case 'CRISDates':
                $spreadsheet = new xlsTools\CRISDates('xls/' . $filename . '.xls', $leadAdmin, $leadRepository, $countyRepository);
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
            $templateParameters['notFound'] = $spreadsheet->notFound;
        }

        return $this->render('GJGNYDataToolBundle:Spreadsheets:results.html.twig', $templateParameters);
    }
    
    public function utilityAction($utility)
    {
        switch($utility)
        {
            case 'convertCountyData':
                return new Response($this->convertCountyData());
                break;
            case 'removeUnusedCounties':
                return new Response($this->removeUnusedCounties());
                break;
        }
        return new Response('No valid utility selected');
    }
    
    protected function removeUnusedCounties()
    {
        $countyRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:County');
        $em = $this->getDoctrine()->getEntityManager();        
        $response = "";

        foreach($countyRepository->findAll() as $county)
        {
            if(count($county->getLeads()) == 0) {
                $response .= $county->__toString()." has 0 leads<br/>";
            }
        }
        
        return $response;
    }
    
    protected function convertCountyData()
    {
        $leadRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:Lead');
        $countyRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:County');
        $em = $this->getDoctrine()->getEntityManager();        
        $response = "";
        
        $q = $em->createQuery('select l from GJGNYDataToolBundle:Lead l');
        $iterableResult = $q->iterate();

        while (($row = $iterableResult->next()) !== false) 
        {
            $lead = $row[0];

            if($lead->getCounty()) {
                $county = $countyRepository->findOneByName($lead->getCounty());

                if(!$county) {
                    $response .= "County ".$lead->getCounty()." not found<br/>";
                } else {
                    $lead->setCountyEntity($county);
                    $lead->setCounty(null);
                    $em->persist($lead);
                }
            }
            $em->flush();
            $em->clear();
        }

        $response .= "County Data Converted";
        
        return $response;
    }

}