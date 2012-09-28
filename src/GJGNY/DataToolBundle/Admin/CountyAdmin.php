<?php

namespace GJGNY\DataToolBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class CountyAdmin extends Admin
{
    protected $entityLabelPlural = "Counties";
    protected $entityIconPath = 'bundles/sonataadmin/famfamfam/map.png';

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);

        if(!$this->hasRequest())
        {
            $this->datagridValues = array(
                '_page' => 1,
                '_sort_order' => 'ASC', // sort direction
                '_sort_by' => 'name' // field name
            );
        }
    }

    
    /* LIST --------------------------------------------- */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('name', 'string', array('label' => 'Name'))
                
                // add custom action links
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'view' => array(),
                        'delete' => array(),
                        'edit' => array(),
                    ),
                    'label' => 'Actions'
                ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('name', null, array('label' => 'Name'))
        ;
    }
    

    
    /* Form --------------------------------------------- */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('name', null, array('label' => 'Name'))
        ;
    }

    
    /* Show --------------------------------------------- */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('name', null, array('label' => 'Name'))
        ;

    }

}