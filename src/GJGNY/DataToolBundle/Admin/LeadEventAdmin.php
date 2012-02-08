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
use GJGNY\DataToolBundle\Entity\LeadEvent as LeadEvent;

class LeadEventAdmin extends Admin
{

    protected $maxPerPage = 20;
    protected $classnameLabel = 'Lead Events';
    protected $entityLabel = "Lead Event";
    protected $entityLabelPlural = "Lead Events";
    protected $entityIconPath = 'bundles/sonataadmin/famfamfam/phone.png';
    
    
    // Form ======================================================================
    // ===========================================================================
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Basic Event Data')
                ->add('Lead', 'sonata_type_model', array(), array('edit' => 'list'))
                ->add('eventType', 'choice', array(
                    'label' => 'Event Type',
                    'required' => false,
                    'choices' => LeadEvent::getEventTypeChoices()
                ))
                ->add('eventTypeOther', null, array('label' => 'Other', 'required' => false))
                ->add('contactPerson', null, array('label' => 'Contact Person', 'required' => false))
                ->add('date', null, array('label' => 'Date of event', 'required' => false, 'time_widget' => 'choice', 'date_widget' => 'choice', 'date_format' => 'MM/dd/yyyy'))
                ->add('description', null, array('label' => 'Description', 'required' => false))
                ->add('WhatWasDiscussed', null, array('label' => 'What was discussed?', 'required' => false))
                ->add('actionsTaken', null, array(
                    'label' => 'Actions taken',
                    'required' => false,
                ))
                ->add('FollowUpItems', null, array('label' => 'Items to follow-up on in future', 'required' => false))
                ->add('notes', null, array('label' => 'Notes', 'required' => false))
            ->end()
            ->setHelps(array(
                'Lead' => 'Click the list icon above to view a list of Leads.  Click the name of the Lead you want.'
            ))
            ->with('Phone Call')
                ->add('callStatus', 'choice', array(
                    'label' => 'Call status',
                    'required' => false,
                    'choices' => LeadEvent::getCallStatusChoices()
                ))
                ->add('callNotes', null, array('label' => 'Notes', 'required' => false))
            ->end()
            ->with('Training Referral')
                ->add('institution', null, array('label' => 'Institution', 'required' => false))
                ->add('program', null, array('label' => 'Program', 'required' => false))
                ->add('dateOfTrainingReferral', null, array('label' => 'Date of referral', 'required' => false, 'widget' => 'choice', 'format' => 'MM/dd/yyyy'))
                ->add('dateOfCompletion', null, array('label' => 'Date of completion', 'required' => false, 'widget' => 'choice', 'format' => 'MM/dd/yyyy'))
            ->end()
            ->with('Job Referral')
                ->add('business', null, array('label' => 'Business', 'required' => false))
                ->add('dateOfJobReferral', null, array('label' => 'Date of referral', 'required' => false, 'widget' => 'choice', 'format' => 'MM/dd/yyyy'))
            ->end()
        ;
    }
   
    
    public $formFieldPreHooks = array(
        // "other" fields
        'lutCouponType' => 'SonataAdminBundle:Hook:_otherFormFieldPre.html.twig',
        'eventTypeOther' => 'SonataAdminBundle:Hook:_otherFormFieldPre.html.twig'
    );
    
    public $formFieldPostHooks = array(
        // "other" fields
        'lutCouponType' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'eventTypeOther' => 'SonataAdminBundle:Hook:_closingDiv.html.twig'
    );
    
    // List ======================================================================
    // ===========================================================================
    public $listPreHook = array('template' => 'GJGNYDataToolBundle:LeadEvent:_listPreHook.html.twig');
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('Lead')    
            ->add('date', 'date', array('label' => 'Date of Event','template' => 'GJGNYDataToolBundle:LeadEvent:_date.html.twig'))
            ->add('eventType', null, array('label' => 'Event Type', 'template' => 'GJGNYDataToolBundle:LeadEvent:_eventType.html.twig'))
            ->add('description', null, array('label' => 'Description', 'template' => 'GJGNYDataToolBundle:LeadEvent:_description.html.twig'))

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
    
    public function configureDatagridFilters(DatagridMapper $datagrid)
    {

        $datagrid->add('firstName', 'doctrine_orm_callback', array(
            'label' => 'First Name',
            'callback' => function ($queryBuilder, $alias, $field, $values) {
                if(!$values['value'])
                {
                    return;
                }

                if(!$queryBuilder->getParameter('county') && !$queryBuilder->getParameter('lastName'))
                {
                    $queryBuilder->leftjoin(sprintf('%s.Lead', $alias), 'l');
                }
                $queryBuilder->andWhere('l.FirstName LIKE :firstName');
                $queryBuilder->setParameter('firstName', '%' . $values['value'] . '%');
            },
            'field_options' => array(
                'required' => false,
            ),
        ));
        $datagrid->add('lastName', 'doctrine_orm_callback', array(
            'label' => 'Last Name',
            'callback' => function ($queryBuilder, $alias, $field, $values) {
                if(!$values['value'])
                {
                    return;
                }

                if(!$queryBuilder->getParameter('firstName') && !$queryBuilder->getParameter('county'))
                {
                    $queryBuilder->leftjoin(sprintf('%s.Lead', $alias), 'l');
                }
                $queryBuilder->andWhere('l.LastName LIKE :lastName');
                $queryBuilder->setParameter('lastName', '%' . $values['value'] . '%');
            },
            'field_options' => array(
                'required' => false,
            ),
        ));
        $datagrid->add('eventType', 'doctrine_orm_callback', array(
            'label' => 'Event type',
            'callback' => function ($queryBuilder, $alias, $field, $values) {
                if(!$values['value'])
                {
                    return;
                }

                $queryBuilder->andWhere($alias . '.eventType = :type OR ' . $alias . '.eventTypeOther = :type');
                $queryBuilder->setParameter('type', $values['value']);
            },
            'field_options' => array(
                'required' => false,
            )
        ));
        $datagrid->add('callStatus', 'doctrine_orm_choice', array(
            'label' => 'Call status',
            'field_options' => array(
                'required' => false,
            ),
            'choices' => LeadEvent::getCallStatusChoices()
        ));
        $datagrid->add('contactPerson', null, array('label' => 'Contact Person'));
        $datagrid->add('dataCounty', 'doctrine_orm_callback', array(
            'label' => 'County Data',
            'callback' => function ($queryBuilder, $alias, $field, $values) {
                if(!$values['value'])
                {
                    return;
                }

                if(!$queryBuilder->getParameter('firstName') && !$queryBuilder->getParameter('lastName'))
                {
                    $queryBuilder->leftjoin(sprintf('%s.Lead', $alias), 'l');
                }
                $queryBuilder->andWhere('l.dataCounty = :county');
                $queryBuilder->setParameter('county', $values['value']);
            },
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => array('Broome' => 'Broome', 'Tompkins' => 'Tompkins')
            )
        ));

        $this->initializeDefaultFilters();
    }

        
    public $hiddenFilters = array(
        'contactPerson' => true,
        'callStatus' => true
    );

    public function initializeDefaultFilters()
    {
        $this->filterDefaults['dataCounty'] = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser()->getCounty();
    }
    
    protected function configureSpreadsheetFields(SpreadsheetMapper $spreadsheetMapper)
    {
        $spreadsheetMapper
            ->add('Lead', array('type' => 'relation', 'relation_field_name' => 'Lead_id', 'relation_repository' => 'GJGNYDataToolBundle:Lead'))
            ->add('eventType', array('label' => 'Event Type'))
            ->add('eventTypeOther', array('label' => 'Other Event Type'))
            ->add('contactPerson', array('label' => 'Contact Person'))
            ->add('date', array('label' => 'Date of event', 'type' => 'date'))
            ->add('description', array('label' => 'Description'))
            ->add('notes', array('label' => 'Notes'))
            ->add('callStatus', array('label' => 'Call status'))
            ->add('WhatWasDiscussed', array('label' => 'What was discussed?'))
            ->add('actionsTaken', array('label' => 'Actions taken'))
            ->add('FollowUpItems', array('label' => 'Items to follow-up on in future'))
            ->add('callNotes', array('label' => 'Notes'))
        ;
    }
    
    protected function configureSummaryFields(SummaryMapper $summaryMapper)
    {
        $summaryMapper
            ->addXField('eventType', array('label' => 'Event Type', 'other_field' => 'eventTypeOther'))
            ->addXField('contactPerson', array('label' => 'Contact Person'))
            ->addYField('date', array('label' => 'Date', 'type' => 'date'))
        ;
    }

    // Show ======================================================================
    // ===========================================================================
    public $showPreHook = array(
        'template' => 'GJGNYDataToolBundle:LeadEvent:_leadLink.html.twig',
    );
    
    public function initializeShowHooks()
    {
        $this->showPreHook['parameters'] = array(
            'LeadAdmin' =>  $this->configurationPool->getContainer()->get('gjgny.datatool.admin.lead')
        );
    }

    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Basic Event Data')
                ->add('eventType', null, array('label' => 'Event Type'))
                ->add('eventTypeOther', null, array('label' => 'other'))
                ->add('date', null, array('label' => 'Date of Event'))
                ->add('contactPerson', null, array('label' => 'Contact Person'))
                ->add('description', null, array('label' => 'Description'))
                ->add('WhatWasDiscussed', null, array('label' => 'What was discussed?'))
                ->add('actionsTaken', null, array('label' => 'Actions Taken'))
                ->add('FollowUpItems', null, array('label' => 'Follow-Up Items'))
                ->add('notes', null, array('label' => 'Notes'))
                ->add('enteredBy', null, array('label' => 'Entered By'))
                ->add('datetimeEntered', null, array('label' => 'Date Entered'))
                ->add('lastUpdatedBy', null, array('label' => 'Last Updated By'))
                ->add('datetimeLastUpdated', null, array('label' => 'Date Last Updated'))
            ->end()
            ->with('Phone Call Data')
                ->add('callStatus', null, array('label' => 'Call Status'))
                ->add('callNotes', null, array('label' => 'Call Notes'))
//                ->add('canWeCallBack', null, array('label' => 'Can we call back?'))
            ->end()
                ->with('Training Referral')
                ->add('institution', null, array('label' => 'Institution'))
                ->add('program', null, array('label' => 'Program'))
                ->add('dateOfTrainingReferral', null, array('label' => 'Date of referral'))
                ->add('dateOfCompletion', null, array('label' => 'Date of completion'))
            ->end()
            ->with('Job Referral')
                ->add('business', null, array('label' => 'Business', 'required' => false))
                ->add('dateOfJobReferral', null, array('label' => 'Date of referral'))
            ->end()
        ;
        
        $this->initializeShowHooks();
    }    

    public $showFieldClasses = array (
        'lutCouponType' => 'indented',
        'eventTypeOther' => 'indented'
    );

    
    public function prePersist($LeadEvent)
    {
        $LeadEvent->setDatetimeEntered(new \DateTime());
        $LeadEvent->setDatetimeLastUpdated(new \DateTime());
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
        $LeadEvent->setEnteredBy($user);
        $LeadEvent->setLastUpdatedBy($user);

        parent::prePersist($LeadEvent);
    }

    public function preUpdate($LeadEvent)
    {
        $LeadEvent->setDatetimeLastUpdated(new \DateTime());
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
        $LeadEvent->setLastUpdatedBy($user);

        parent::preUpdate($LeadEvent);
    }

}

