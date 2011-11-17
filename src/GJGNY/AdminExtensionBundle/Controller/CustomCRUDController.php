<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GJGNY\AdminExtensionBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sonata\AdminBundle\Controller\CRUDController;

class CustomCRUDController extends CRUDController
{

    /**
     * return the Response object associated to the list action
     *
     * @return Response
     */
    public function listAction()
    {
        if(false === $this->admin->isGranted('LIST'))
        {
            throw new AccessDeniedException();
        }

        // check each hidden filter to see if it was requested, so we can show the hidden filters in the template
        $showHiddenFilters = false;

        foreach($this->admin->hiddenFilters as $filterName => $value)
        {
            if($this->getRequest()->get($filterName) && $this->getRequest()->get($filterName) != "")
            {
                $showHiddenFilters = true;
            }
        }

        $filterValues = $this->admin->getDatagrid()->getValues();

        foreach($this->admin->filterDefaults as $field => $default)
        {
            if(!isset($filterValues[$field]))
            {
                $this->admin->getDatagrid()->setValue($field, $default);
            }    
        }
        
        return $this->render($this->admin->getListTemplate(), array(
            'action' => 'list',
            'admin' => $this->admin,
            'base_template' => $this->getBaseTemplate(),
            'groups' => $this->get('sonata.admin.pool')->getDashboardGroups(),
            'showHiddenFilters' => $showHiddenFilters,
        ));
    }

    /**
     * return the Response object associated to the edit action
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @param  $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
        if(false === $this->admin->isGranted('EDIT'))
        {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getObject($this->get('request')->get($this->admin->getIdParameter()));

        if(!$object)
        {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->setSubject($object);

        $form = $this->admin->getForm($object);

        if($this->get('request')->getMethod() == 'POST')
        {
            $form->bindRequest($this->get('request'));

            if($form->isValid())
            {
                $this->admin->update($object);

                if($this->isXmlHttpRequest())
                {
                    return $this->renderJson(array(
                        'result' => 'ok',
                        'objectId' => $this->admin->getNormalizedIdentifier($object)
                    ));
                }

                // redirect to edit mode
                return $this->redirectTo($object);
            }
        }

        return $this->render($this->admin->getEditTemplate(), array(
            'action' => 'edit',
            'form' => $form->createView(),
            'object' => $object,
            'admin' => $this->admin,
            'base_template' => $this->getBaseTemplate(),
            'groups' => $this->get('sonata.admin.pool')->getDashboardGroups(),
        ));
    }

    /**
     * redirect the user depend on this choice
     *
     * @param  $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function redirectTo($object)
    {
        $url = false;

        if($this->get('request')->get('btn_update_and_list'))
        {
            $url = $this->admin->generateUrl('list');

            $this->getRequest()->getSession()->setFlash('adminMessage', $this->admin->getClassSingular() . ' saved');
        }
        else if($this->get('request')->get('btn_create_and_list'))
        {
            $url = $this->admin->generateUrl('list');

            $this->getRequest()->getSession()->setFlash('adminMessage', $this->admin->getClassSingular() . ' created');
        }

        if(!$url)
        {
            $url = $this->admin->generateUrl('edit', array(
                        'id' => $this->admin->getNormalizedIdentifier($object),
                    ));
        }

        return new RedirectResponse($url);
    }

    /**
     * return the Response object associated to the create action
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        if(false === $this->admin->isGranted('CREATE'))
        {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getNewInstance();
        $form = $this->admin->getForm($object);

        $this->admin->setSubject($object);

        if($this->get('request')->getMethod() == 'POST')
        {
            $form->bindRequest($this->get('request'));

            if($form->isValid())
            {
                // If adding a lead, check the db for the name
                if($this->admin->getClassnameLabel() == 'Leads')
                {
                    $leadMayBeInDB = false;

                    $firstName = $object->getFirstName();
                    $lastName = $object->getLastName();

                    $leadRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:Lead');
                    $lead = $leadRepository->findBy(array('FirstName' => $firstName, 'LastName' => $lastName));

                    if($lead)
                    {
                        if(!$this->getRequest()->getSession()->get('areYouSure'))
                        {
                            $leadMayBeInDB = true;
                            $this->getRequest()->getSession()->set('areYouSure', true);
                        }
                        else
                        {
                            $this->getRequest()->getSession()->set('areYouSure', null);
                        }
                    }
                }

                if($this->admin->getClassnameLabel() == 'Leads' && $leadMayBeInDB)
                {
                    $this->getRequest()->getSession()->setFlash('pageErrorMessage', 'There is already a Lead in the database with this name.  Please check the list before creating this Lead.
                    If you are sure that this Lead is not already in the DB, click "create" again.');
                }
                else
                {
                    $this->admin->create($object);

                    if($this->isXmlHttpRequest())
                    {
                        return $this->renderJson(array(
                            'result' => 'ok',
                            'objectId' => $this->admin->getNormalizedIdentifier($object)
                        ));
                    }

                    // redirect to edit mode
                    return $this->redirectTo($object);
                }
            }
        }

        return $this->render($this->admin->getEditTemplate(), array(
            'action' => 'create',
            'form' => $form->createView(),
            'object' => $object,
            'base_template' => $this->getBaseTemplate(),
            'admin' => $this->admin,
            'groups' => $this->get('sonata.admin.pool')->getDashboardGroups()
        ));
    }

    /**
     * return the Response object associated to the view action
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id)
    {
        if(false === $this->admin->isGranted('VIEW'))
        {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getObject($this->get('request')->get($this->admin->getIdParameter()));

        if(!$object)
        {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->setSubject($object);

        // build view labels and parent fields
        foreach($this->admin->viewGroups as $name => $viewGroup)
        {
            foreach($viewGroup['fields'] as $fieldName)
            {
                $desc = $this->admin->getViewFieldDescriptions();

                if(isset($this->admin->viewLabels[$fieldName]))
                {
                    $desc[$fieldName]->setName($this->admin->viewLabels[$fieldName]);
                }

                if(isset($this->admin->viewChoiceParentFields[$fieldName]))
                {
                    $desc[$fieldName]->setOption('parentField', $this->admin->viewChoiceParentFields[$fieldName]);
                }
                else
                {
                    $desc[$fieldName]->setOption('parentField', '');
                }

                if(isset($this->admin->viewFieldsToIndent[$fieldName]))
                {
                    $desc[$fieldName]->setOption('labelStyles', 'text-align: right;');
                }
                else
                {
                    $desc[$fieldName]->setOption('labelStyles', '');
                }
            }
        }

        return $this->render($this->admin->getViewTemplate(), array(
            'action' => 'view',
            'object' => $object,
            'base_template' => $this->getBaseTemplate(),
            'admin' => $this->admin,
            'groups' => $this->get('sonata.admin.pool')->getDashboardGroups()
        ));
    }

    /**
     * execute a batch delete
     *
     * @param array $idx
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function batchActionDelete($query)
    {
        if(false === $this->admin->isGranted('DELETE'))
        {
            throw new AccessDeniedException();
        }

        $modelManager = $this->admin->getModelManager();
        $modelManager->batchDelete($this->admin->getClass(), $query);

        $this->getRequest()->getSession()->setFlash('adminMessage', $this->admin->getClassPlural() . ' deleted');

        // todo : add confirmation flash var
        return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }

    public function deleteAction($id)
    {
        if(false === $this->admin->isGranted('DELETE'))
        {
            throw new AccessDeniedException();
        }

        $id = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if(!$object)
        {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->getRequest()->getSession()->setFlash('adminMessage', $this->admin->getClassSingular() . ' deleted');

        $this->admin->delete($object);

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

}