<?php
namespace GJGNY\DataToolBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Datagrid\ORM\ProxyQuery;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;

class LeadAdminController extends Controller
{
    /**
     * return the Response object associated to the create action
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        if(false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getNewInstance();
        
        $object = $this->processUrlFormValues($object);        

        $object->setEnteredBy($this->get('security.context')->getToken()->getUser());
        $object->setUserAssignedTo($this->get('security.context')->getToken()->getUser());
        
        $this->admin->setSubject($object);

        $form = $this->admin->getForm();
        $form->setData($object);
        
        $this->processFormFieldHooks($object);

        if($this->get('request')->getMethod() == 'POST') {
            $form->bindRequest($this->get('request'));

            if($form->isValid()) {
                if(isset($this->admin->fieldGroupsToCheckForDuplicates)) {
                    $itemMayBeInDB = false;
                    $itemFound = false;
                    $repository = $this->getDoctrine()->getRepository($this->admin->getClass());

                    foreach($this->admin->fieldGroupsToCheckForDuplicates as $fieldGroup) {
                        if(!is_array($fieldGroup)) $fieldGroup = array($fieldGroup);

                        $parameters = array();
                        
                        foreach($fieldGroup as $field) {
                            $methodName = 'get'.ucfirst($field);
                   
                            if(!$object->$methodName()) continue 2; // if any field in a group is not set, skip the group
                            
                            $parameters[$field] = $object->$methodName();
                        }
                        $result = $repository->findBy($parameters);

                        if($result) $itemFound = true;
                    }
                    
                    if($itemFound)
                    {
                        if(!$this->getRequest()->getSession()->get('areYouSure'))
                        {
                            $itemMayBeInDB = true;
                            $this->getRequest()->getSession()->set('areYouSure', true);
                        }
                        else
                        {
                            $this->getRequest()->getSession()->set('areYouSure', null);
                        }
                    }
                }
                
                if($this->admin->getClassnameLabel() == 'Leads' && $itemMayBeInDB) {
                    $this->getRequest()->getSession()->setFlash('sonata_flash_error', 'This '.$this->admin->getEntityLabel().' may already by in the database.  Please check the list before creating it.
                    If you are sure that this '.$this->admin->getEntityLabel().' is not already in the database, click "Create" again.');
                } else {

                    $this->admin->create($object);

                    if($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                                    'result' => 'ok',
                                    'objectId' => $this->admin->getNormalizedIdentifier($object)
                                ));
                    }

                    $this->get('session')->setFlash('sonata_flash_success', 'flash_create_success');
                    // redirect to edit mode
                    return $this->redirectTo($object);
                }
            } else {
                $this->get('session')->setFlash('sonata_flash_error', 'flash_create_error');
            }
        }

        $view = $form->createView();

        // sort the Program Source choices
        $array = $view['Program']->get('choices');
        asort($array);
        $view['Program']->set('choices', $array);

        $array = $view['userAssignedTo']->get('choices');
        asort($array);
        $view['userAssignedTo']->set('choices', $array);        
        
        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getEditTemplate(), array(
            'action' => 'create',
            'form'   => $view,
            'object' => $object,
        ));
    }
     /**
     * return the Response object associated to the edit action
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @param  $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id = null)
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if(!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('EDIT', $object)) {
            throw new AccessDeniedException();
        }

        $this->admin->setSubject($object);

        $form = $this->admin->getForm();
        $form->setData($object);

        $this->processFormFieldHooks($object);

        if($this->get('request')->getMethod() == 'POST') {
            $form->bindRequest($this->get('request'));

            if($form->isValid()) {
                $this->admin->update($object);
                $this->get('session')->setFlash('sonata_flash_success', 'flash_edit_success');

                if($this->isXmlHttpRequest()) {
                    return $this->renderJson(array(
                                'result' => 'ok',
                                'objectId' => $this->admin->getNormalizedIdentifier($object)
                            ));
                }

                // redirect to edit mode
                return $this->redirectTo($object);
            }

            $this->get('session')->setFlash('sonata_flash_error', 'flash_edit_error');
        }

        $view = $form->createView();

        // sort the Program Source choices
        $array = $view['Program']->get('choices');
        asort($array);
        $view['Program']->set('choices', $array);        
        
        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getEditTemplate(), array(
                    'action' => 'edit',
                    'form' => $view,
                    'object' => $object,
                ));
    }
    
    public function assignLeadsSelectUserAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        // get users
        $userRepository = $this->getDoctrine()->getRepository("ApplicationSonataUserBundle:User");
        $currentUser = $this->get('security.context')->getToken()->getUser();
        $users = $userRepository->findBy(array('county' => $currentUser->getCounty()), array('firstName' => "ASC"));
        $userChoices = array();
        
        foreach($users as $user)
        {
            $userChoices[$user->getId()] = $user->__toString();
        }
        
        
        $form = $this->createFormBuilder()
            ->add('userFrom', 'choice', array(
                'choices' => $userChoices,
                'label' => 'Transfer a selection of this User\'s Leads:'
            ))
            ->add('userTo', 'choice', array(
                'choices' => $userChoices,
                'label' => 'to this User:'
            ));
        
        $form->
            addValidator(new CallbackValidator(function(FormInterface $form)
            {
                if ($form["userFrom"]->getData() == $form["userTo"]->getData())
                {
                    $form->addError(new FormError('Please select two different users'));
                }
            })
        );
       
        $form = $form->getForm();
        
        if($this->get('request')->getMethod() == 'POST') {
            $form->bindRequest($this->get('request'));

            if($form->isValid()) {
                $data = $form->getData();

                return new RedirectResponse($this->admin->generateUrl('assignLeads', array('userFromId' => $data['userFrom'], 'userToId' => $data['userTo'])));              
            }
        }
        
        return $this->render("GJGNYDataToolBundle:Lead:assignLeadsSelectUser.html.twig", array(
                    'form' => $form->createView(),
                    'action' => 'assignLeadsSelectUser',
                ));
        
    }
    
    public function assignLeadsAction($userFromId, $userToId)
    {
        $userRepository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:User');
        $userFrom = $userRepository->findOneById($userFromId);       
        $userTo = $userRepository->findOneById($userToId);
        $em = $this->getDoctrine()->getEntityManager();

        if(count($userFrom->getLeadsAssignedTo()) > 0) {
            $leadChoices = array();        

            foreach($userFrom->getLeadsAssignedTo() as $lead)
            {
                $leadChoices[$lead->getId()] = $lead->__toString();
            }

            $form = $this->createFormBuilder()
                ->add('leads', 'choice', array(
                    'choices' => $leadChoices,
                    'multiple' => true,
                    'expanded' => true,
                    'label' => "Transfer which of ".$userFrom->__toString()."'s Leads to ".$userTo->__toString()."?"
                ))
                ->getForm();

            if($this->get('request')->getMethod() == 'POST') {
                $form->bindRequest($this->get('request'));

                if($form->isValid()) {
                    $data = $form->getData();

                    foreach($data['leads'] as $leadId)
                    {
                        $leadRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:Lead');
                        $lead = $leadRepository->findOneById($leadId);

                        $lead->setUserAssignedTo($userTo);
                        $em->persist($lead);
                        $em->flush();
                    }

                    $this->get('session')->setFlash('sonata_flash_success', count($data['leads']).' Leads have been transferred.');
                    return new RedirectResponse($this->admin->generateUrl('list'));              
                }
            }

            return $this->render("GJGNYDataToolBundle:Lead:assignLeads.html.twig", array(
                        'form' => $form->createView(),
                        'action' => 'assignLeads',
                        'userTo' => $userTo,
                        'userFrom' => $userFrom
                    ));
        } else {
            $this->get('session')->setFlash('sonata_flash_error', $userFrom->__toString().' has no Leads to transfer.');
                return new RedirectResponse($this->admin->generateUrl('assignLeadsSelectUser'));   
        }
    }
    public function batchActionTransfer($query)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $currentUser = $this->get('security.context')->getToken()->getUser();

        foreach($query->getQuery()->iterate() as $pos => $object) {
            $object[0]->setUserAssignedTo($currentUser);
        }

        $em->flush();
        $em->clear();

        $this->getRequest()->getSession()->setFlash('sonata_flash_success', 'The selected Leads have been transferred');

        return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }
}