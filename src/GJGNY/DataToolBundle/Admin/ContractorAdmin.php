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

class ContractorAdmin extends Admin
{

    protected $maxPerPage = 30;
    protected $entityIconPath = 'bundles/sonataadmin/famfamfam/wrench.png';

    // Form ======================================================================
    // ===========================================================================
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('name')
                ->add('address')
                ->add('phone')
                ->add('email')
                ->add('website')
                ->add('specialties')
                ->add('file', 'file', array('label' => 'Logo', 'required' => false))
        ;
    }
    
    public $formFieldPostHooks = array(
        'file' => 'GJGNYDataToolBundle:Contractor:_currentLogo.html.twig'
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
                ->add('filename', 'string', array('label' => 'Logo', 'template' => 'GJGNYDataToolBundle:PortalPartnerLogo:_listLogo.html.twig'))
                ->addIdentifier('name')
                ->add('website')
                ->add('address')
                ->add('phone')
                ->add('email')
                
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
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('filename', 'string', array('label' => 'Logo', 'template' => 'GJGNYDataToolBundle:Contractor:_showLogo.html.twig'))        
            ->add('name')
            ->add('address')
            ->add('phone')
            ->add('email')
            ->add('website')
            ->add('specialties')
        ;
    }
        
}
