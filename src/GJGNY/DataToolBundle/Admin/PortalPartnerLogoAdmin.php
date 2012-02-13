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

class PortalPartnerLogoAdmin extends Admin
{
    protected $entityLabel = 'Partner Logo';
    protected $maxPerPage = 10;
    protected $entityIconPath = 'bundles/sonataadmin/famfamfam/photo.png';

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);

        if(!$this->hasRequest())
        {
            $this->datagridValues = array(
                '_page' => 1,
                '_sort_order' => 'DESC', // sort direction
                '_sort_by' => 'rank' // field name
            );
        }
    }
    
    
    // Form ======================================================================
    // ===========================================================================
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('portal')
                ->add('file', 'file', array('label' => 'Logo', 'required' => false))
                ->add('url', null, array('label' => 'Logo URL', 'required' => false))
                ->add('rank', 'text', array('label' => 'Rank'))
                ->setHelps(array(
                    'rank' => 'determines the order of the logos (the higher the number, the sooner it appears)'
                ))
                
      ;
    }
    public $formFieldPostHooks = array(
        'file' => 'GJGNYDataToolBundle:PortalPartnerLogo:_currentLogo.html.twig'
    );
   
    // List ======================================================================
    // ===========================================================================
    //public $listPreHook = array('template' => 'GJGNYDataToolBundle:Program:_listPreHook.html.twig');

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('portal')        
                ->add('filename', 'string', array('label' => 'Logo', 'template' => 'GJGNYDataToolBundle:PortalPartnerLogo:_listLogo.html.twig'))
                ->add('url', null, array('label' => 'Url', 'template' => 'GJGNYDataToolBundle:PortalPartnerLogo:_listUrl.html.twig'))
                ->add('rank')
                
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
        $datagrid->add('portal');
    }

    // Show ======================================================================
    // ===========================================================================
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('portal', null, array('label' => 'Portal'))
                ->add('filename', 'string', array('label' => 'Logo', 'template' => 'GJGNYDataToolBundle:PortalPartnerLogo:_showLogo.html.twig'))
                ->add('url', null, array('label' => 'Url', 'template' => 'GJGNYDataToolBundle:PortalPartnerLogo:_showUrl.html.twig'))
                ->add('rank')
        ;
    }
 
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
}
