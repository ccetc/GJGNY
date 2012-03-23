<?php

/*
 * This file is part of the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace GJGNY\DataToolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PortalController extends Controller
{

    public function portalAction($url, $signup = false)
    {
        $portalRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:Portal');
        $portal = $portalRepository->findOneByUrl($url);

        $portalPartnerLogoRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:PortalPartnerLogo');
        $partnerLogos = $portalPartnerLogoRepository->findBy(array('portal' => $portal->getId()), array('rank' => 'DESC'));

        $portalSettingsRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:PortalSettings');
        $portalSettings = $portalSettingsRepository->findAll(array('portal' => $portal));

        $counties = array();

        foreach($portalSettings as $ps) {
            foreach($ps->getCountiesServed() as $cs) {
                $counties[$cs->getId()] = $cs->getName();
            }
        }

        asort($counties);

        if($signup) {
            $request = $this->getRequest();

            $form = $this->createFormBuilder()
                    ->add('firstName', 'text', array('label' => 'First Name'))
                    ->add('lastName', 'text', array('label' => 'Last Name'))
                    ->add('email', 'text', array('label' => 'E-mail'))
                    ->add('phone', 'text', array('label' => 'Phone'))
                    ->add('town', 'text', array('label' => 'Town'))
                    ->add('county', 'choice', array('label' => 'County', 'choices' => $counties))
                    ->getForm();

            if($request->getMethod() == 'POST') {
                $form->bindRequest($request);

                if($form->isValid()) {
                    $session = $this->getRequest()->getSession();
                    $data = $form->getData();

                    $countyRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:County');
                    $userCounty = $countyRepository->findOneBy(array('id' => $data['county']));

                    foreach($portalSettings as $ps) {
                        foreach($ps->getCountiesServed() as $cs) {
                            if($cs->getId() == $data['county']) {
                                $portalMatch = $ps;
                                break 2;
                            }
                        }
                    }

                    $lead = new \GJGNY\DataToolBundle\Entity\Lead();
                    $lead->setFirstName($data['firstName']);
                    $lead->setLastName($data['lastName']);
                    $lead->setPersonalEmail($data['email']);
                    $lead->setTown($data['town']);
                    $lead->setCounty($userCounty->getName());
                    $lead->setDatetimeEntered(new \DateTime());
                    $lead->setLeadStatus('active lead');
                    $lead->setNeedToCall(true);
                    $lead->setProgram($portalMatch->getNotificationProgram());
                    $lead->setDataCounty($portalMatch->getCountyOwnedBy());
		    $lead->setPhone($data['phone']);
		    
                    $newLeadLink = $this->getPageLink().'/admin/gjgny/datatool/lead/list'.
                            '?filter[Program][type]=&filter[Program][value]='.$portalMatch->getNotificationProgram()->getId().
                            '&filter[FirstName][type]=&filter[FirstName][value]='.$data['firstName'].
                            '&filter[LastName][type]=&filter[LastName][value]='.$data['lastName']
                            ;
                    
                    foreach($portalMatch->getNotificationUsers() as $notificationUser) {
                        $this->sendSignupNotificationEmail($lead, $notificationUser->getEmail(), $newLeadLink);
                    }

	            $leadAdmin = $this->get('gjgny.datatool.admin.lead');        	    
	            $leadAdmin->create($lead);

                    $session->setFlash('page-message', 'You have been signed up.  Thank you.');

                    return $this->redirect($this->generateUrl('portal', array('url' => $portal->getUrl())));
                }
            }
        }

        $templateParameters = array(
            'portal' => $portal,
            'partnerLogos' => $partnerLogos,
            'signup' => $signup
        );

        if($signup)
            $templateParameters['form'] = $form->createView();

        return $this->render('GJGNYDataToolBundle:Portal:portal.html.twig', $templateParameters);
    }

    protected function sendSignupNotificationEmail($signup, $to, $newLeadLink)
    {
        $message = \Swift_Message::newInstance()
                ->setSubject('GJGNY Portal - Sign Up Submitted')
                ->setFrom('noreply@ccetompkins.org')
                ->setTo($to)
                ->setContentType('text/html')
                ->setBody('<html>
                       <a href="mailto:'.$signup->getPersonalEmail().'">'.$signup->getFirstName().' '.$signup->getLastName().'</a> signed up via the GJGNY Portal.<br/><br/>
                       <a href="'.$newLeadLink.'">' . $newLeadLink . '</a></html>')
        ;
        $this->get('mailer')->send($message);

    }
    
    protected function getPageLink()
    {
        $httpHost = $this->container->get('request')->getHttpHost();
        $baseUrl = $this->container->get('request')->getBaseUrl();
        return 'http://' . $httpHost . $baseUrl;
    }

}
