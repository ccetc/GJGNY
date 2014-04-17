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
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;

use GJGNY\DataToolBundle\Entity\Lead;

class PortalController extends Controller
{
    public function homeAction($url)
    {
        $templateParameters = $this->getBaseTemplateParameters($url);
        $testimonialRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:Testimonial');
        $templateParameters['testimonials'] = $testimonialRepository->findByFeatured(true);

        return $this->render('GJGNYDataToolBundle:Portal:home.html.twig', $templateParameters);
    }

    public function contractorsAction($url)
    {
        $contractorRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:Contractor');

        $templateParameters = $this->getBaseTemplateParameters($url);

        $templateParameters['contractors'] = $contractorRepository->findBy(array(), array('name' => 'ASC'));

        return $this->render('GJGNYDataToolBundle:Portal:contractors.html.twig', $templateParameters);
    }

    public function testimonialsAction($url)
    {
        $templateParameters = $this->getBaseTemplateParameters($url);

        return $this->render('GJGNYDataToolBundle:Portal:testimonials.html.twig', $templateParameters);
    }

    public function testimonialAction($url, $id)
    {
        $templateParameters = $this->getBaseTemplateParameters($url);
        $testimonialRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:Testimonial');
        $templateParameters['testimonial'] = $testimonialRepository->findOneById($id);

        return $this->render('GJGNYDataToolBundle:Portal:testimonial.html.twig', $templateParameters);
    }

    public function signupAction($url)
    {
        $em = $this->getDoctrine()->getEntityManager();        
        $templateParameters = $this->getBaseTemplateParameters($url);
        extract($templateParameters);

        $request = $this->getRequest();
        $portalSettingsRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:PortalSettings');
        $portalSettings = $portalSettingsRepository->findAll(array('portal' => $portal));

        $counties = array();

        foreach($portalSettings as $ps) {
            foreach($ps->getCountiesServed() as $cs) {
                $counties[$cs->getId()] = $cs->getName();
            }
        }

        asort($counties);

        $form = $this->createFormBuilder()
                ->add('firstName', 'text', array('label' => 'First Name', 'required' => true))
                ->add('lastName', 'text', array('label' => 'Last Name', 'required' => true))
                ->add('email', 'text', array('label' => 'E-mail', 'required' => true))
                ->add('phone', 'text', array('label' => 'Phone', 'required' => true))
                ->add('address', 'text', array('label' => 'Address', 'required' => true))
                ->add('town', 'text', array('label' => 'Town', 'required' => true))
                ->add('zip', 'text', array('label' => 'Zip', 'required' => true))
                ->add('county', 'choice', array('label' => 'County', 'choices' => $counties, 'required' => true))
                ->add('state', 'choice', array(
                    'label' => 'State',
                    'required' => true,
                    'choices' => Lead::getStateChoices(),
                    'preferred_choices' => array('NY', 'PA')
                ))
                ->add('outreachOrganization', 'choice', array(
                    'label' => 'Outreach Organization',
                    'required' => true,
                    'choices' => array('PPEF' => 'PPEF', 'STSW' => 'STSW'),
                ))
                ->add('solar', 'choice', array(
                    'label' => 'Interested in Solar Site Assessment',
                    'required' => true,
                    'choices' => array('yes' => 'yes', 'no' => 'no'),
                ))
                ->add('energyUpgrade', 'choice', array(
                    'label' => 'Interested in Home Energy Audit',
                    'required' => true,
                    'choices' => array('yes' => 'yes', 'no' => 'no'),
                ))
                ->add('SourceOfLead', 'choice', array(
                    'required' => true,
                    'label' => 'How did you hear about us?',
                    'choices' => Lead::getSourceOfLeadChoices()
                ))
                ->add('message', 'textarea', array('label' => 'Message'));

        $form->
            addValidator(new CallbackValidator(function(FormInterface $form)
            {
                if (!$form["firstName"]->getData() && trim($form["firstName"]->getData()) == "" )
                {
                    $form->addError(new FormError('Please enter your first name'));
                }
            })
        );
        $form->
            addValidator(new CallbackValidator(function(FormInterface $form)
            {
                if (!$form["lastName"]->getData() && trim($form["lastName"]->getData()) == "" )
                {
                    $form->addError(new FormError('Please enter your last name'));
                }
            })
        );
        $form->
            addValidator(new CallbackValidator(function(FormInterface $form)
            {
                if (!$form["phone"]->getData() && trim($form["phone"]->getData()) == "" )
                {
                    $form->addError(new FormError('Please enter your phone number'));
                }
            })
        );
        $form->
            addValidator(new CallbackValidator(function(FormInterface $form)
            {
                if (!$form["email"]->getData() && trim($form["email"]->getData()) == "" )
                {
                    $form->addError(new FormError('Please enter your email'));
                }
            })
        );
        $form->
            addValidator(new CallbackValidator(function(FormInterface $form)
            {
                if (!$form["zip"]->getData() && trim($form["zip"]->getData()) == "" )
                {
                    $form->addError(new FormError('Please enter your zip'));
                }
            })
        );
        $form->
            addValidator(new CallbackValidator(function(FormInterface $form)
            {
                if (!$form["address"]->getData() && trim($form["address"]->getData()) == "" )
                {
                    $form->addError(new FormError('Please enter your address'));
                }
            })
        );
        $form->
            addValidator(new CallbackValidator(function(FormInterface $form)
            {
                if (!$form["state"]->getData() && trim($form["state"]->getData()) == "" )
                {
                    $form->addError(new FormError('Please enter your state'));
                }
            })
        );
        
        $form = $form->getForm();
            
            
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
                $lead->setZip($data['zip']);
                $lead->setAddress($data['address']);
                $lead->setState($data['state']);
                $lead->setCountyEntity($userCounty);
                $lead->setDatetimeEntered(new \DateTime());
                $lead->setLeadStatus('active lead');
                $lead->setNeedToCall(true);
                $lead->setProgram($portalMatch->getNotificationProgram());
                $lead->setDataCounty($portalMatch->getCountyOwnedBy());
                $lead->setPhone($data['phone']);
                $lead->setOtherNotes($data['message']);
                $lead->setOutreachOrganization($data['outreachOrganization']);
                $lead->setSourceOfLead($data['SourceOfLead']);

                echo $data['solar'];
                echo $data['outreachOrganization'];

                if($data['solar'] && $data['solar'] == 'yes') {
                    $lead->setLeadTypeSolar(true);
                }
                if($data['energyUpgrade'] && $data['energyUpgrade'] == 'yes') {
                    $lead->setLeadTypeUpgrade(true);
                }
        
                $newLeadLink = $this->getPageLink().'/admin/gjgny/datatool/lead/list'.
                        '?filter[Program][type]=&filter[Program][value]='.$portalMatch->getNotificationProgram()->getId().
                        '&filter[FirstName][type]=&filter[FirstName][value]='.$data['firstName'].
                        '&filter[LastName][type]=&filter[LastName][value]='.$data['lastName']
                        ;
                
                foreach($portalMatch->getNotificationUsers() as $notificationUser) {
                    $this->sendSignupNotificationEmail($lead, $notificationUser->getEmail(), $newLeadLink);
                }

                
                // create the lead
                // NOTES:
                //  - we need to be able to insert the lead, and add object acl permissions even though there is no logged in user
                //  - this code is copied from SonataAdminBundle\Security\Handler\AclSecurityHandler->createObjectSecurity
                //
                $leadAdmin = $this->get('gjgny.datatool.admin.lead');               
         
                $leadAdmin->getModelManager()->create($lead);
                
                $securityHandler = $leadAdmin->getSecurityHandler();

                $objectIdentity = ObjectIdentity::fromDomainObject($lead);
                $acl = $securityHandler->getObjectAcl($objectIdentity);
                if (is_null($acl)) {
                    $acl = $securityHandler->createAcl($objectIdentity);
                }

                $securityHandler->addObjectClassAces($acl, $securityHandler->buildSecurityInformation($leadAdmin));
                $securityHandler->updateAcl($acl);
                
                $session->setFlash('page-message', 'You have been signed up.  Thank you.');

                return $this->redirect($this->generateUrl('portal', array('url' => $portal->getUrl())));
            }
        }

        $templateParameters['form'] = $form->createView();

        return $this->render('GJGNYDataToolBundle:Portal:signup.html.twig', $templateParameters);
    }

    public function getBaseTemplateParameters($url)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $portalRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:Portal');
        $portal = $portalRepository->findOneByUrl($url);

        $portalPartnerLogoRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:PortalPartnerLogo');
        $partnerLogos = $portalPartnerLogoRepository->findBy(array('portal' => $portal->getId()), array('rank' => 'DESC'));

        $templateParameters = array(
            'portal' => $portal,
            'partnerLogos' => $partnerLogos,
            'route' => $this->getRequest()->get('_route')
        );

        return $templateParameters;
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
