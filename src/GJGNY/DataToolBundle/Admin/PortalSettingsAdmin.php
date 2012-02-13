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

class PortalSettingsAdmin extends Admin
{

    protected $maxPerPage = 10;
    protected $entityLabel = 'Portal Settings';
    protected $entityLabelPlural = 'Portal Settings';
    protected $entityIconPath = 'bundles/sonataadmin/famfamfam/cog.png';

    // Form ======================================================================
    // ===========================================================================
    public $formPreHook = array('template' => 'GJGNYDataToolBundle:PortalSettings:_listPreHook.html.twig');
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->with('Basic Settings')
                    ->add('portal', null, array('label' => 'Portal'))
                    ->add('countiesServed', null, array('label' => 'Counties', 'expanded' => 'true', 'multiple' => 'true'))
                ->end()
                ->with('Notifications')
                    ->add('notificationUsers', null, array('label' => 'Users to Notify', 'expanded' => 'true', 'multiple' => 'true'))
                ->end()
                ->with('Data Tool Integration')
                    ->add('notificationProgram', null, array('label' => 'Program Source'))
                    ->add('countyOwnedBy', null, array('label' => 'Outreach County'))
                ->end()
                ->setHelps(array(
                    'countiesServed' => 'Signups from these counties will be sent to the list of users below, and added as Leads for the Outreach County below',
                    'countyOwnedBy' => 'The county that this outreach is based in',
                ))
      ;
    }
   
    // List ======================================================================
    // ===========================================================================
    public $listPreHook = array('template' => 'GJGNYDataToolBundle:PortalSettings:_listPreHook.html.twig');

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('portal')
                ->add('countyOwnedBy', null, array('label' => 'Outreach County'))
                ->add('countiesServed', null, array('label' => 'Counties Served'))
                                
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
                ->with('Basic Settings')
                    ->add('portal', null, array('label' => 'Portal'))
                    ->add('countiesServed', null, array('label' => 'Counties'))
                ->end()
                ->with('Notifications')
                    ->add('notificationUsers', null, array('label' => 'Users to Notify'))
                ->end()
                ->with('Data Tool Integration')
                    ->add('notificationProgram', null, array('label' => 'Program Source'))
                    ->add('countyOwnedBy', null, array('label' => 'Outreach County'))
                ->end()
        ;
    }
        
}
