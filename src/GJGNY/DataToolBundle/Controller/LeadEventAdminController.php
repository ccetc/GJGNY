<?php
namespace GJGNY\DataToolBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Datagrid\ORM\ProxyQuery;

class LeadEventAdminController extends Controller
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
        
        $object->setContactPerson($this->get('security.context')->getToken()->getUser()->__toString());
                
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
        
        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getEditTemplate(), array(
            'action' => 'create',
            'form'   => $view,
            'object' => $object,
        ));
    }
}