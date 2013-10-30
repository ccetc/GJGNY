<?php

namespace GJGNY\DataToolBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Spreadsheet\SpreadsheetMapper;
use Sonata\AdminBundle\Summary\SummaryMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class PortalAdmin extends Admin
{

    protected $maxPerPage = 10;
    protected $entityIconPath = 'bundles/sonataadmin/famfamfam/door.png';

    // Form ======================================================================
    // ===========================================================================
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('title', null, array('label' => 'Title'))
                ->add('url', null, array('label' => 'Url'))
                ->add('contactUs', null, array('label' => 'Contact Us', 'attr' => array('class' => 'tinymce')))
                ->add('events', null, array('label' => 'Events', 'attr' => array('class' => 'tinymce')))
                ->add('mainLogoFile', 'file', array('label' => 'Main Logo', 'required' => false))
                ->add('mainLogoUrl', null, array('label' => 'Main Logo URL', 'required' => false))
                ->add('googleAnalyticsKey', null, array('label' => 'Google Analytics Key', 'required' => false))
                ->setHelps(array(
                    'url' => 'http://gjgny.ccext/portal/YourUrl',
                ))
      ;
    }
    public $formFieldPostHooks = array(
        'mainLogoFile' => 'GJGNYDataToolBundle:Portal:_currentMainLogo.html.twig'
    );
    
    public function prePersist($object)
    {
        $this->saveFile($object);
    }

    public function preUpdate($object)
    {
        $this->saveFile($object);
    }

    public function saveFile($object)
    {
        $object->upload();
    }
   
    // List ======================================================================
    // ===========================================================================
    //public $listPreHook = array('template' => 'GJGNYDataToolBundle:Program:_listPreHook.html.twig');

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('title', 'string', array('label' => 'Title'))
                ->add('url', null, array('label' => 'Url'))
                
                // add custom action links
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'view' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    ),
                    'label' => 'Actions'
                ))
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagrid)
    {
    }

    // Show ======================================================================
    // ===========================================================================
    public $showPreHook = array(
        'template' => 'GJGNYDataToolBundle:Portal:_showPreHook.html.twig',
    );
    
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('title', null, array('label' => 'Title'))
                ->add('url', null, array('label' => 'Url'))
                ->add('contactUs', null, array('label' => 'Contact Us', 'template' => 'GJGNYDataToolBundle:Portal:_showContactUs.html.twig'))
                ->add('events', null, array('label' => 'Events', 'template' => 'GJGNYDataToolBundle:Portal:_showEvents.html.twig'))
                ->add('mainLogoFilename', null, array('label' => 'Main Logo', 'template' => 'GJGNYDataToolBundle:Portal:_showMainLogo.html.twig'))
                ->add('mainLogoUrl', null, array('label' => 'Main Logo URL', 'template' => 'GJGNYDataToolBundle:Portal:_showMainLogoUrl.html.twig'))                
        ;
    }
        
}
