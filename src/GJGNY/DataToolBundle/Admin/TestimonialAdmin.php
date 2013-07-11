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

class TestimonialAdmin extends Admin
{

    protected $maxPerPage = 10;
    protected $entityLabel = 'Testimonial';
    protected $entityLabelPlural = 'Testimonials';
    protected $entityIconPath = 'bundles/sonataadmin/famfamfam/comment.png';

    // Form ======================================================================
    // ===========================================================================
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('portal', null, array('label' => 'Portal'))
            ->add('name', null, array('label' => 'Name'))
            ->add('location', null, array('label' => 'Location'))
            ->add('quote', null, array('label' => 'Quote'))
            ->add('text', null, array('label' => 'Text', 'attr' => array('class' => 'tinymce')))
            ->add('file', 'file', array('label' => 'Photo', 'required' => false))            
            ->add('youtubeUrl', null, array('label' => 'YouTube URL'))
            ->add('featured')
      ;
    }
   public $formFieldPostHooks = array(
        'file' => 'GJGNYDataToolBundle:PortalPartnerLogo:_currentLogo.html.twig'
    );

    // List ======================================================================
    // ===========================================================================
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('name')
                ->add('featured')            
                                
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
            ->add('portal', null, array('label' => 'Portal'))
            ->add('name', null, array('label' => 'Name'))
            ->add('location', null, array('label' => 'Location'))
            ->add('quote', null, array('label' => 'Quote'))
            ->add('text', null, array('label' => 'Text'))
            ->add('filename', 'string', array('label' => 'Photo', 'template' => 'GJGNYDataToolBundle:PortalPartnerLogo:_showLogo.html.twig'))
            ->add('youtubeUrl', null, array('label' => 'YouTube URL'))
            ->add('featured')            
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
