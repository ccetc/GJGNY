<?php

namespace GJGNY\DataToolBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use GJGNY\DataToolBundle\Entity\LeadEvent as LeadEvent;
use GJGNY\AdminExtensionBundle\Admin\CustomAdmin;

class LeadEventAdmin extends CustomAdmin
{

  protected $maxPerPage = 20;
  protected $classnameLabel = 'Lead Events';
  public $classname = "LeadEvent";
  protected $entityDescription = "A Lead Event usually represents an instance of contact with a Lead, such as a phone call.  A Lead Event could also indicate the date that a Lead got an assessment or upgrade.";
// Form ======================================================================
// ===========================================================================
  protected $formGroups = array(
      'Basic Event Data' => array(
          'fields' => array(
              'Lead',
              'eventType',
              'eventTypeOther',
              'contactPerson',
              'date',
              'description',
              'notes',
          )
      ),
      'Phone Call Data' => array(
          'fields' => array(
              'callStatus',
              'WhatWasDiscussed',
              'actionsTaken',
              'FollowUpItems',
              'callNotes',
              'canWeCallBack'
          ),
          'collapsed' => false
      ),
      'Lighten Up Tompkins Phone Survey Data' => array(
          'fields' => array(
              'lutBulb',
              'lutBulbReplace',
              'lutLookAtMaterials',
              'lutMaterialsUseful',
              'lutStepsTaken',
              'lutStepsTakenGeneral',
              'lutRentOrOwn',
              'lutBarriers',
              'lutAssessment',
              'lutSupport',
              'lutNewsletter',
              'lutQuestions',
              'lutCouponMailed',
              'lutCouponType',
          ),
          'collapsed' => true
      )
  );

  public function configureFormFields(FormMapper $form)
  {
    $form
// basic event info
            ->add('Lead', array(), array('edit' => 'list',
                'inline' => 'table',
                'sortable' => 'position'))
            ->add('date', array('label' => 'Date of event', 'required' => false))
            ->add('eventType', array(
                'label' => 'Event Type',
                'required' => false,
                'choices' => LeadEvent::getEventTypeChoices()
                    ), array('type' => 'choice'))
            ->add('eventTypeOther', array('label' => 'Other', 'required' => false))
            ->add('description', array('label' => 'Description', 'required' => false))
            ->add('notes', array('label' => 'Notes', 'required' => false))


// phone call data
            ->add('contactPerson', array('label' => 'Contact Person', 'required' => false))
            ->add('callStatus', array(
                'label' => 'Call status',
                'required' => false,
                'choices' => LeadEvent::getCallStatusChoices()
                    ), array('type' => 'choice')
            )
            ->add('WhatWasDiscussed', array('label' => 'What was discussed?', 'required' => false))
            ->add('FollowUpItems', array('label' => 'Items to follow-up on in future', 'required' => false))
            ->add('actionsTaken', array(
                'label' => 'Actions taken',
                'required' => false,
            ))
            ->add('canWeCallBack', array('label' => 'Can we call back?', 'required' => false))
            ->add('callNotes', array('label' => 'Notes', 'required' => false))

// LUT phone survey data
            ->add('lutBulb', array('label' => 'Did you screw in your light bulb?', 'required' => false))
            ->add('lutBulbReplace', array('label' => 'Did you replace an incandescent?', 'required' => false))
            ->add('lutLookAtMaterials', array('label' => 'Did you get a chance to look at the education materials in the bag?', 'required' => false))
            ->add('lutMaterialsUseful', array('label' => 'Where the educational materials useful?', 'required' => false))
            ->add('lutStepsTaken', array('label' => 'What every savings steps have you taken in your home as a result of Lighten Up Tompkins?', 'required' => false))
            ->add('lutStepsTakenGeneral', array('label' => 'What energy savings steps have you taken in your home in general?', 'required' => false))
            ->add('lutRentOrOwn', array('label' => 'Do you rent or own?', 'required' => false, 'choices' => array('rent' => 'rent', 'own' => 'own')), array('type' => 'choice'))
            ->add('lutBarriers', array('label' => 'What are your barriers to making home energy upgrades?', 'required' => false))
            ->add('lutAssessment', array('label' => 'Have you had an energy assessment by an energy efficieny contractor?', 'required' => false))
            ->add('lutSupport', array('label' => 'What support do you need in taking additional energy saving steps?', 'required' => false))
            ->add('lutNewsletter', array('label' => 'Would you be interested in receiving a monthly e-mail newsletter?', 'required' => false))
            ->add('lutQuestions', array('label' => 'What questions do you have?', 'required' => false))
            ->add('lutCouponMailed', array('label' => 'Coupon mailed?', 'required' => false))
            ->add('lutCouponType', array('label' => 'if so, what type?', 'required' => false)
    );
  }

  public $brAfterFields = array(
      'lutBulb' => true,
      'lutBulbReplace' => true,
      'lutLookAtMaterials' => true,
      'lutMaterialsUseful' => true,
      'lutAssessment' => true,
      'lutNewsletter' => true,
  );
  public $otherFields = array(
      'lutCouponType' => true,
      'eventTypeOther' => true
  );
// List ======================================================================
// ===========================================================================
  protected $list = array(
      'Lead',
      'date' => array('name' => 'Date of Event', 'template' => 'GJGNYDataToolBundle:LeadEvent:_date.html.twig'),
      'eventType' => array('name' => 'Event Type', 'template' => 'GJGNYDataToolBundle:LeadEvent:_eventType.html.twig'),
      'description' => array('name' => 'Description', 'template' => 'GJGNYDataToolBundle:LeadEvent:_description.html.twig'),
      '_action' => array(
          'actions' => array(
              'delete' => array(),
              'edit' => array(),
              'view' => array()
          )
      )
  );
  public function getBatchActions()
  {
    return array(
        'Delete' => 'Delete Selected',
    );
  }

  protected $filter = array(
      'description'
  );
  public $hiddenFilters = array(
      'contactPerson' => true,
      'callStatus' => true
  );

  public function configureDatagridFilters(DatagridMapper $datagrid)
  {
   
    $datagrid->add('firstName', array(
        'name' => 'First Name',
        'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
        'type' => 'callback',
        'filter_options' => array(
            'filter' => array($this, 'handleFirstNameFilter'),
        ),
        'filter_field_options' => array(
            'required' => false,
        ),
    ));
    $datagrid->add('lastName', array(
        'name' => 'Last Name',
        'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
        'type' => 'callback',
        'filter_options' => array(
            'filter' => array($this, 'handleLastNameFilter'),
        ),
        'filter_field_options' => array(
            'required' => false,
        ),
    ));
    $datagrid->add('eventType', array(
        'name' => 'Event type',
        'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
        'type' => 'callback',
        'filter_options' => array(
            'filter' => array($this, 'handleEventTypeFilter'),
        ),
        'filter_field_options' => array(
            'required' => false,
        )
    ));
    $datagrid->add('callStatus', array(
        'name' => 'Call status',
        'type' => 'choice',
        'filter_field_options' => array(
            'required' => false,
            'choices' => LeadEvent::getCallStatusChoices()
        )
    ));
    $datagrid->add('contactPerson', array('name' => 'Contact Person'));
    $datagrid->add('dataCounty', array(
        'name' => 'County Data',
        'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
        'type' => 'callback',
        'filter_options' => array(
            'filter' => array($this, 'handleDataCountyFilter'),
            'type' => 'choice'
        ),
        'filter_field_options' => array(
            'required' => false,
            'choices' => array('Broome' => 'Broome', 'Tompkins' => 'Tompkins')
        )
    ));
    
    $this->initializeDefaultFilters();
  }
  
  public function handleFirstNameFilter($queryBuilder, $alias, $field, $value)
  {
    if(!$value)
    {
      return;
    }
    
    if(!$queryBuilder->getParameter('county') && !$queryBuilder->getParameter('lastName'))
    {
      $queryBuilder->leftjoin(sprintf('%s.Lead', $alias), 'l');
    }
    $queryBuilder->andWhere('l.FirstName LIKE :firstName');
    $queryBuilder->setParameter('firstName', '%' . $value . '%');
  }
  
  public function handleLastNameFilter($queryBuilder, $alias, $field, $value)
  {
    if(!$value)
    {
      return;
    }
    
    if(!$queryBuilder->getParameter('firstName') && !$queryBuilder->getParameter('county'))
    {
      $queryBuilder->leftjoin(sprintf('%s.Lead', $alias), 'l');
    }
    $queryBuilder->andWhere('l.LastName LIKE :lastName');
    $queryBuilder->setParameter('lastName', '%' . $value . '%');
  }
  
  
  public function handleEventTypeFilter($queryBuilder, $alias, $field, $value)
  {
    if(!$value)
    {
      return;
    }

    $queryBuilder->andWhere($alias . '.eventType = :type OR '.$alias.'.eventTypeOther = :type');
    $queryBuilder->setParameter('type', $value);
  }
  
  public function handleDataCountyFilter($queryBuilder, $alias, $field, $value)
  {
    if(!$value)
    {
      return;
    }
    
    if(!$queryBuilder->getParameter('firstName') && !$queryBuilder->getParameter('lastName'))
    {
      $queryBuilder->leftjoin(sprintf('%s.Lead', $alias), 'l');
    }
    $queryBuilder->andWhere('l.dataCounty = :county');
    $queryBuilder->setParameter('county', $value);
  }
  
  public function initializeDefaultFilters()
  {
      $this->filterDefaults['dataCounty'] = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser()->getCounty();
  }
  

// View ======================================================================
// ===========================================================================
  public $viewLabels = array(
      'eventType' => 'Event Type',
      'eventTypeOther' => 'Other',
      'date' => 'Date',
      'description' => 'Description',
      'notes' => 'Notes',
      'contactPerson' => 'Contact Person',
      'callStatus' => 'Call Status',
      'WhatWasDiscussed' => 'What was discussed?',
      'actionsTaken' => 'Actions Taken',
      'FollowUpItems' => 'Follow-up Items',
      'callNotes' => 'Call Notes',
      'lutBulb' => 'Did you screw in your light bulb?',
      'lutBulbReplace' => 'Did you replace an incandescent?',
      'lutLookAtMaterials' => 'Did you get a chance to look at the education materials in the bag?',
      'lutMaterialsUseful' => 'Where the educational materials useful?',
      'lutStepsTaken' => 'What every savings steps have you taken in your home as a result of Lighten Up Tompkins?',
      'lutStepsTakenGeneral' => 'What energy savings steps have you taken in your home in general?',
      'lutRentOrOwn' => 'Do you rent or own?',
      'lutBarriers' => 'What are your barriers to making home energy upgrades?',
      'lutAssessment' => 'Have you had an energy assessment by an energy efficieny contractor?',
      'lutSupport' => 'What support do you need in taking additional energy saving steps?',
      'lutNewsletter' => 'Would you be interested in receiving a monthly e-mail newsletter?',
      'lutQuestions' => 'What questions do you have?',
      'lutCouponMailed' => 'Coupon mailed?',
      'lutCouponType' => 'if so, what type?',
      'enteredBy' => 'Data Entered By',
      'datetimeEntered' => 'Data Entered: ',
      'lastUpdatedBy' => 'Data Last Updated By',
      'datetimeLastUpdated' => 'Data Last Updated:',
      'canWeCallBack' => 'Can we call back?'
  );
  public $viewFieldsToIndent = array(
      'lutCouponType' => true,
      'eventTypeOther' => true
  );
  protected $view = array(
      'Lead',
      'eventType',
      'eventTypeOther',
      'date',
      'description',
      'notes',
      'contactPerson',
      'callStatus',
      'WhatWasDiscussed',
      'actionsTaken',
      'FollowUpItems',
      'callNotes',
      'lutBulb',
      'lutBulbReplace',
      'lutLookAtMaterials',
      'lutMaterialsUseful',
      'lutStepsTaken',
      'lutStepsTakenGeneral',
      'lutRentOrOwn',
      'lutBarriers',
      'lutAssessment',
      'lutSupport',
      'lutNewsletter',
      'lutQuestions',
      'lutCouponMailed',
      'lutCouponType',
      'enteredBy',
      'datetimeEntered',
      'lastUpdatedBy',
      'datetimeLastUpdated',
      'canWeCallBack'
  );
  public $viewGroups = array(
      'Basic Event Data' => array(
          'fields' => array(
              'Lead',
              'eventType',
              'eventTypeOther',
              'date',
              'contactPerson',
              'description',
              'notes',
              'enteredBy',
              'datetimeEntered',
              'lastUpdatedBy',
              'datetimeLastUpdated',              
          )
      ),
      'Phone Call Data' => array(
          'fields' => array(
              'callStatus',
              'WhatWasDiscussed',
              'actionsTaken',
              'FollowUpItems',
              'callNotes',
              'canWeCallBack'
          ),
      ),
      'Lighten Up Tompkins Phone Survey Data' => array(
          'fields' => array(
              'lutBulb',
              'lutBulbReplace',
              'lutLookAtMaterials',
              'lutMaterialsUseful',
              'lutStepsTaken',
              'lutStepsTakenGeneral',
              'lutRentOrOwn',
              'lutBarriers',
              'lutAssessment',
              'lutSupport',
              'lutNewsletter',
              'lutQuestions',
              'lutCouponMailed',
              'lutCouponType',
          ),
      )
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

