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

use GJGNY\DataToolBundle\Entity\Lead as Lead;
use GJGNY\DataToolBundle\Entity\Program as Program;
use GJGNY\DataToolBundle\Admin\LeadEventAdmin as LeadEventAdmin;

class ProgramAdmin extends Admin
{

    protected $maxPerPage = 10;
    protected $classnameLabel = 'Programs';
    protected $entityLabel = 'Program';
    protected $entityLabelPlural = 'Programs';
    protected $entityIconPath = 'images/icons/Program.png';

    // Form ======================================================================
    // ===========================================================================
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('name', null, array('label' => 'Name'))
                ->add('date', null, array('label' => 'Date', 'widget' => 'choice', 'format' => 'MM/dd/yyyy'))
      ;
    }
   
    // List ======================================================================
    // ===========================================================================
    public $listPreHook = 'GJGNYDataToolBundle:Program:_listPreHook.html.twig';

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('name', 'string', array('label' => 'Name'))
                ->add('date', null, array('label' => 'Date'))
                
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
        $datagrid->add('name', null, array('label' => 'Name'));
        $datagrid->add('date', 'doctrine_orm_date_range', array('label' => 'Date'));
        $datagrid->add('dataCounty', 'doctrine_orm_choice', array(
            'label' => 'County Data',
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => array('Broome' => 'Broome', 'Tompkins' => 'Tompkins')
            )
        ));
        $this->initializeDefaultFilters();
    }

    public function initializeDefaultFilters()
    {
       $this->filterDefaults['dataCounty'] = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser()->getCounty();
    }

    // Show ======================================================================
    // ===========================================================================
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('name', null, array('label' => 'Name'))
                ->add('date', null, array('label' => 'Date'))
        ;
        
        $this->initializeShowHooks();
    }
        
    public $showPreHook = array(
        'template' => 'GJGNYDataToolBundle:Program:_showPreHook.html.twig',
    );
       
    public function initializeShowHooks()
    {
        $this->showPreHook['parameters'] = array(
            'LeadAdmin' =>  $this->configurationPool->getContainer()->get('gjgny.datatool.admin.lead')
        );
    }
    
    
    public function prePersist($Program)
    {
        $Program->setDatetimeEntered(new \DateTime());
        $Program->setDatetimeLastUpdated(new \DateTime());
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
        $Program->setEnteredBy($user);
        $Program->setLastUpdatedBy($user);
        $Program->setDataCounty($user->getCounty());

        parent::prePersist($Program);
    }

    public function preUpdate($Program)
    {
        $Program->setDatetimeLastUpdated(new \DateTime());
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
        $Program->setLastUpdatedBy($user);

        parent::preUpdate($Program);
    }

}
