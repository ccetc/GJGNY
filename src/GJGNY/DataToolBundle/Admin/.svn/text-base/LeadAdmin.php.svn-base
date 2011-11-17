<?php

namespace GJGNY\DataToolBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use GJGNY\DataToolBundle\Entity\Lead as Lead;
use GJGNY\AdminExtensionBundle\Admin\CustomAdmin;
use GJGNY\DataToolBundle\Admin\LeadEventAdmin as LeadEventAdmin;

class LeadAdmin extends CustomAdmin
{

  protected $maxPerPage = 10;
  protected $classnameLabel = 'Leads';
  protected $classSingular = 'Lead';
  public $classname = 'Lead';
  protected $entityDescription = "A Lead represents an individual potentially interested in a home energy assessment and upgrade.  Each Lead has contact information, employer information, and specific information about their interest in getting an assessment and upgrade, and their progress along that path.";
  // Form ======================================================================
  // ===========================================================================
  protected $formGroups = array(
      'Lead Information' => array(
          'fields' => array(
              'FirstName',
              'middleInitial',
              'LastName',
              'Address',
              'City',
              'State',
              'Zip',
              'Town',
              'county',
              'phone',
              'primaryPhoneType',
              'secondaryPhone',
              'secondaryPhoneType',
              'personalEmail',
              'workEmail',
              'Employer',
          ),
          'collapsed' => false
      ),
      'Lead History' => array (
          'fields' => array (
              'SourceOfLead',
              'ProgramSource',
              'leadReferral',
              'DateOfLead',
              'leadType',
              'leadStatus',
              'DateOfNextFollowup',
          )
      ),
      'Employer / Organization Information' => array(
          'fields' => array(
              'organization',
              'orgTitle',
              'orgAddress',
              'orgCity',
              'orgState',
              'orgZip',
              'orgCounty',
              'website',
          )
      ),
      'Other Information' => array(
          'fields' => array(
              'CommunityGroupsConnectedTo',
              'barriers',
              'interestedInVisit',
              'motivationChoiceComfort', 'motivationChoiceMoney', 'motivationChoiceIndoorAir', 'motivationChoiceEnvironment', 'motivationChoiceOther',
              'campaignChoiceTalkingToNeighbors', 'campaignChoiceFormEnergyTeam', 'campaignChoiceAppearInVideo', 'campaignChoiceShareExperience',
              'newsletterChoiceEnergyTips', 'newsletterChoiceSavings', 'newsletterChoiceEvents',
              'otherNotes',
          ),
          'collapsed' => false
      ),
      'Energy Path Steps' => array(
          'fields' => array(
              'step1',
              'step1aActionsTaken',
              'step2',
              'step2aInterested', 'step2bSubmitted', 'step2cScheduled', 'step2dCompleted',
              'step3',
              'step3aContractor', 'step3bWorkDone', 'step3cHowFinanced',
              'step4',
              'step5'
          ),
          'collapsed' => true
      ),
      'Broome Fields' => array(
          'fields' => array(
              'pledge',
              'visitPeriod',
              'BECCTeam',
              'rank'
          ),
          'collapsed' => true
      ),
      'Tompkins Fields' => array(
          'fields' => array(
              'october2011Raffle',
          ),
          'collapsed' => true
      ),
      'GJGNY Application Data' => array(
          'fields' => array(
              'hasCentralAC',
              'incomeRange',
              'buildingType',
              'sqFootage',
              'financeChoiceHomeEquity', 'financeChoiceGJGNY', 'financeChoicePocket', 'financeChoicePersonal',
              'GJGNYReference', 'GJGNYReferenceOther',
              'electricUtility', 'electricUtilityAcct',
              'gasUtility', 'gasUtilityAcct',
              'otherFuelSupplier',
              'otherFuelSupplierType',
              'otherFuelSupplierTypeOther',
              'otherFuelSupplierAcct'
          ),
          'collapsed' => true
      )
  );

  public function configureFormFields(FormMapper $form)
  {
    // Basic Information
    $form->add('FirstName', array('label' => 'First Name', 'required' => false));
    $form->add('middleInitial', array('label' => 'middle initial', 'required' => false));
    $form->add('LastName', array('label' => 'Last Name', 'required' => false));
    $form->add('Address', array('required' => false));
    $form->add('City', array('label' => 'City (mailing address)', 'required' => false));
    $form->add('State', array(
        'label' => 'State',
        'required' => false,
        'choices' => Lead::getStateChoices(),
        'preferred_choices' => array('NY')
            ), array('type' => 'choice'));
    $form->add('Zip', array('required' => false));
    $form->add('Town', array('required' => false));
    $form->add('county', array('required' => false));
    $form->add('phone', array('required' => false));
    $form->add('primaryPhoneType', array('label' => 'type', 'required' => false));
    $form->add('secondaryPhone', array('label' => 'Secondary Phone', 'required' => false));
    $form->add('secondaryPhoneType', array('label' => 'type', 'required' => false));
    $form->add('personalEmail', array('label' => 'Personal E-mail', 'required' => false));
    $form->add('workEmail', array('label' => 'Work E-mail', 'required' => false));
    
    $form->add('SourceOfLead', array('required' => false, 'label' => 'Source of Lead', 'choices' => Lead::getSourceOfLeadChoices()), array('type' => 'choice'));
    $form->add('ProgramSource', array('required' => false, 'label' => 'Program Source'));
    $form->add('DateOfLead', array('label' => 'Date of First Contact', 'required' => false));
    $form->add('leadReferral', array('required' => false, 'label' => 'Referral / Nomination'));
    $form->add('leadType', array('required' => false, 'label' => 'Type of Lead', 'choices' => Lead::getLeadTypeChoices()), array('type' => 'choice'));
    $form->add('leadStatus', array('required' => false, 'label' => 'Lead Status', 'choices' => Lead::getLeadStatusChoices()), array('type' => 'choice'));
    $form->add('DateOfNextFollowup', array('label' => 'Date of next Follow-up', 'required' => false));
    
    
    // org fields
    $form->add('organization', array('label' => 'Employer / Organization', 'required' => false));
    $form->add('orgTitle', array('label' => 'Title', 'required' => false));
    $form->add('orgAddress', array('label' => 'Address', 'required' => false));
    $form->add('orgCity', array('label' => 'City', 'required' => false));
    $form->add('orgState', array(
        'label' => 'State',
        'required' => false,
        'choices' => Lead::getStateChoices(),
        'preferred_choices' => array('NY')
            ), array('type' => 'choice'));
    $form->add('orgZip', array('label' => 'Zip', 'required' => false));
    $form->add('orgCounty', array('label' => 'County', 'required' => false));

    // Other Information
    $form->add('otherNotes', array('label' => 'Other Notes', 'required' => false));
    $form->add('website', array('required' => false));
    $form->add('CommunityGroupsConnectedTo', array('label' => 'Community groups connected to', 'required' => false));
    $form->add('barriers', array('label' => 'Barriers to making upgrades', 'required' => false));
    $form->add('interestedInVisit', array('label' => 'Interested in scheduling a home visit', 'required' => false));

    $form->add('newsletterChoiceEnergyTips', array('label' => 'Energy saving tips', 'required' => false));
    $form->add('newsletterChoiceSavings', array('label' => 'Energy saving programs and incentives', 'required' => false));
    $form->add('newsletterChoiceEvents', array('label' => 'Upcoming workshops and events', 'required' => false));

    $form->add('campaignChoiceTalkingToNeighbors', array('label' => 'Talking to neighbors', 'required' => false));
    $form->add('campaignChoiceFormEnergyTeam', array('label' => 'Forming an energy team', 'required' => false));
    $form->add('campaignChoiceAppearInVideo', array('label' => 'Appear in testimonial video', 'required' => false));
    $form->add('campaignChoiceShareExperience', array('label' => 'Share upgrade experience with others', 'required' => false));

    $form->add('motivationChoiceComfort', array('label' => 'Comfort', 'required' => false));
    $form->add('motivationChoiceMoney', array('label' => 'Money', 'required' => false));
    $form->add('motivationChoiceIndoorAir', array('label' => 'Indoor air quality', 'required' => false));
    $form->add('motivationChoiceEnvironment', array('label' => 'Environment', 'required' => false));
    $form->add('motivationChoiceOther', array('label' => 'Other', 'required' => false));

    // Energy Path Steps
    $form->add('step1', array('label' => 'Low cost / no-cost actions and tune up energy users', 'required' => false));
    $form->add('step1aActionsTaken', array('label' => 'List specific actions taken', 'required' => false));
    $form->add('step2', array('label' => 'Energy Assessment', 'required' => false));
    $form->add('step2aInterested', array('label' => 'Interested in getting assessment', 'required' => false));
    $form->add('step2bSubmitted', array('label' => 'GJGNY application submitted', 'required' => false));
    $form->add('step2cScheduled', array('label' => 'Assessment scheduled', 'required' => false));
    $form->add('step2dCompleted', array('label' => 'Assessment completed and report received', 'required' => false));
    $form->add('step3', array('label' => 'Whole house upgrade', 'required' => false));
    $form->add('step3aContractor', array('label' => 'Name of contractor', 'required' => false));
    $form->add('step3bWorkDone', array('label' => 'What was done (air sealing, insulating, upgrade heating system, etc.)', 'required' => false));
    $form->add('step3cHowFinanced', array('required' => false, 'label' => 'How was it financed', 'choices' => Lead::getHowAssessmentFinancedChoices()), array('type' => 'choice'));
    $form->add('step4', array('label' => 'Upgrade Appliances', 'required' => false));
    $form->add('step5', array('label' => 'Renewable energy', 'required' => false));


    // GJGNY Application Data
    $form->add('financeChoiceHomeEquity', array('label' => 'Home Equity loan', 'required' => false));
    $form->add('financeChoiceGJGNY', array('label' => 'GJGNY load', 'required' => false));
    $form->add('financeChoicePocket', array('label' => 'Out-of-pocker', 'required' => false));
    $form->add('financeChoicePersonal', array('label' => 'Personal loan', 'required' => false));

    $form->add('incomeRange', array('required' => false, 'label' => 'Household Income Range', 'choices' => Lead::getIncomeRangeChoices()), array('type' => 'choice'));
    $form->add('GJGNYReference', array('required' => false, 'label' => 'How did Lead hear about GJGNY program?', 'choices' => Lead::getGJGNYReferenceChoices()), array('type' => 'choice'));
    $form->add('GJGNYReferenceOther', array('label' => 'Other', 'required' => false));

    $form->add('buildingType', array('label' => 'Building Type', 'choices' => Lead::getBuildingTypeChoices(), 'required' => false), array('type' => 'choice'));
    $form->add('sqFootage', array('label' => 'Above grade conditioned square footage', 'required' => false));
    $form->add('electricUtility', array('label' => 'Electric Utility', 'required' => false));
    $form->add('electricUtilityAcct', array('label' => 'Electric Utility Acct #', 'required' => false));
    $form->add('gasUtility', array('label' => 'Gas Utility', 'required' => false));
    $form->add('gasUtilityAcct', array('label' => 'Gas Utility Acct #', 'required' => false));
    $form->add('hasCentralAC', array('label' => 'Central AC?', 'required' => false));
    $form->add('otherFuelSupplier', array('label' => 'Other Fuel Supplier', 'required' => false));
    $form->add('otherFuelSupplierType', array('label' => 'Other Fuel Supplier Type', 'choices' => Lead::getOtherFuelSupplierTypeChoices(), 'required' => false), array('type' => 'choice'));
    $form->add('otherFuelSupplierTypeOther', array('label' => 'Other type', 'required' => false));
    $form->add('otherFuelSupplierAcct', array('label' => 'Other Fuel Supplier Acct #', 'required' => false));

    // Broome data       
    $form->add('pledge', array('label' => 'Pledge', 'required' => false));
    $form->add('visitPeriod', array('label' => 'Visit Period', 'required' => false));
    $form->add('BECCTeam', array('label' => 'BECC Team', 'required' => false));
    $form->add('rank', array('label' => 'Rank', 'required' => false));
    
    // Tompkins data
    $form->add('october2011Raffle', array('label' => 'October 2011 Raffle', 'required' => false));
}

  protected $formLabels = array(
      'financeChoiceHomeEquity' => 'Project Finance Preference',
      'newsletterChoiceEnergyTips' => 'Interested in receiving information newsletter about...',
      'campaignChoiceTalkingToNeighbors' => 'Interested in helping with campagin?',
      'motivationChoiceComfort' => 'Motivation for making energy upgrades',
  );
  // <br/> added after field and label 
  public $brAfterFields = array(
      'newsletterChoiceEvents' => true,
      'campaignChoiceShareExperience' => true,
      'financeChoicePersonal' => true,
      'hasCentralAC' => true
  );
  // field and label put in a div classed 'otherField' for styling
  public $otherFields = array(
      'motivationChoiceOther' => true,
      'GJGNYReferenceOther' => true,
      'otherFuelSupplierTypeOther' => true,
      'primaryPhoneType' => true,
      'secondaryPhoneType' => true
  );
  public $formFieldsToIndent = array(
      'step1aActionsTaken' => true,
      'step2aInterested' => true,
      'step2bSubmitted' => true,
      'step2cScheduled' => true,
      'step2dCompleted' => true,
      'step3aContractor' => true,
      'step3bWorkDone' => true,
      'step3cHowFinanced' => true,
  );
  public $fieldsWithTopMargins = array(
      'step2' => true,
      'step3' => true,
      'step4' => true,
      'step5' => true,
  );
  // List ======================================================================
  // ===========================================================================
  protected $list = array(
      'LastName' => array('identifier' => true, 'name' => 'Name', 'template' => 'GJGNYDataToolBundle:Lead:_name.html.twig'),
      'Contact' => array('type' => 'string', 'template' => 'GJGNYDataToolBundle:Lead:_contact.html.twig'),
      'Address' => array('template' => 'GJGNYDataToolBundle:Lead:_address.html.twig'),
      'SourceOfLead' => array('name' => 'Source of Lead'),
      'ProgramSource' => array('name' => 'Program Source'),
      'DateOfLead' => array('name' => 'Date of First Contact', 'template' => 'GJGNYDataToolBundle:Lead:_dateOfLead.html.twig'),
      //'LeadEvents' => array('name' => 'Lead Events', 'template' => 'GJGNYDataToolBundle:Lead:_leadEvents.html.twig'),
      '_action' => array(
          'actions' => array(
              'delete' => array(),
              'edit' => array(),
              'view' => array(),
          //    'addLeadEvent' => array('template' => 'GJGNYDataToolBundle:Lead:_addLeadEventAction.html.twig')
          )
      )
  );

  public function getBatchActions()
  {
    return array(
        'Delete' => 'Delete Selected',
    );
  }

  public $hiddenFilters = array(
      'personalEmail' => true,
      'workEmail' => true,
      'organization' => true,
      'CommunityGroupsConnectedTo' => true,
      'leadType' => true,
      'Motivation' => true,
      'Newsletter' => true,
      'Campaign' => true,
      'PathStep' => true,
      'step3aContractor' => true,
      'step3bWorkDone' => true,
      'step3cHowFinanced' => true,
      'october2011Raffle' => true
  );
  
  
  public function configureDatagridFilters(DatagridMapper $datagrid)
  {
    $datagrid->add('FirstName', array('name' => 'First name'));
    $datagrid->add('LastName', array('name' => 'Last name'));
    $datagrid->add('City');
    $datagrid->add('Zip');
    $datagrid->add('SourceOfLead', array(
        'name' => 'Source of Lead',
        'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
        'type' => 'callback',
        'filter_options' => array(
            'filter' => array($this, 'handleSourceOfLeadFilter'),
            'type' => 'choice'
        ),
        'filter_field_options' => array(
            'required' => false,
            'choices' => Lead::getSourceOfLeadChoices()
        )
    ));
    $datagrid->add('ProgramSource', array('name' => 'Program Source'));
/*    $datagrid->add('ProgramSource', array(
        'name' => 'Program Source',
        'type' => 'choice',
        'filter_field_options' => array (
            'choices' => LeadRepository:findUniqueProgramSources()
        )
    ));*/
    $datagrid->add('leadType', array(
        'name' => 'Type of Lead',
        'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
        'type' => 'callback',
        'filter_options' => array(
            'filter' => array($this, 'handleLeadTypeFilter'),
            'type' => 'choice'
        ),
        'filter_field_options' => array(
            'required' => false,
            'choices' => Lead::getLeadTypeChoices()
        )
    ));
    $datagrid->add('leadStatus', array(
        'name' => 'Lead Status',
        'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
        'type' => 'callback',
        'filter_options' => array(
            'filter' => array($this, 'handleLeadStatusFilter'),
            'type' => 'choice'
        ),
        'filter_field_options' => array(
            'required' => false,
            'choices' => Lead::getLeadStatusChoices()
        )
    ));
    $datagrid->add('dataCounty', array(
        'name' => 'County Data',
        'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
        'type' => 'choice',
        'filter_field_options' => array(
            'required' => false,
            'choices' => array('Broome' => 'Broome', 'Tompkins' => 'Tompkins')
        )
    ));
    
    $datagrid->add('personalEmail', array('name' => 'Personal E-mail'));
    $datagrid->add('workEmail', array('name' => 'Work E-mail'));
    $datagrid->add('organization', array('name' => 'Work / Organization'));
    $datagrid->add('Motivation', array(
        'name' => 'Motivation for upgrade',
        'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
        'type' => 'callback',
        'filter_options' => array(
            'filter' => array($this, 'handleCheckboxChoiceFilter'),
            'type' => 'choice'
        ),
        'filter_field_options' => array(
            'required' => false,
            'choices' => Lead::getMotivationChoices()
        )
    ));
    $datagrid->add('Campaign', array(
        'name' => 'Capaign interest',
        'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
        'type' => 'callback',
        'filter_options' => array(
            'filter' => array($this, 'handleCheckboxChoiceFilter'),
            'type' => 'choice'
        ),
        'filter_field_options' => array(
            'required' => false,
            'choices' => Lead::getCampaignChoices()
        )
    ));
    $datagrid->add('Newsletter', array(
        'name' => 'Newsletter interest',
        'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
        'type' => 'callback',
        'filter_options' => array(
            'filter' => array($this, 'handleCheckboxChoiceFilter'),
            'type' => 'choice'
        ),
        'filter_field_options' => array(
            'required' => false,
            'choices' => Lead::getNewsletterChoices()
        )
    ));
    $datagrid->add('CommunityGroupsConnectedTo', array('name' => 'Community group connections'));
    $datagrid->add('PathStep', array(
        'name' => 'Energy Path Step',
        'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
        'type' => 'callback',
        'filter_options' => array(
            'filter' => array($this, 'handleCheckboxChoiceFilter'),
            'type' => 'choice'
        ),
        'filter_field_options' => array(
            'required' => false,
            'choices' => Lead::getStepChoices()
        )
    ));
    $datagrid->add('step3aContractor', array('name' => 'Step 3a: Upgrade contractor'));
    $datagrid->add('step3bWorkDone', array('name' => 'Step 3b: Work done'));
    $datagrid->add('step3aContractor', array('name' => 'Step 3c: How was it financed?'));
 
    $datagrid->add('october2011Raffle', array(
        'name' => '10/11 Raffle',
        'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
        'type' => 'callback',
        'filter_options' => array(
            'filter' => array($this, 'handleRaffleFilter'),
            'type' => 'choice'
        ),
        'filter_field_options' => array(
            'required' => false,
            'choices' => array('true' => 'true')
        )
    ));
    
    $this->initializeDefaultFilters();
  }

  public function handleRaffleFilter($queryBuilder, $alias, $field, $value)
  {
    if(!$value)
    {
      return;
    }
    if($value == 'true')
    {
        $queryBuilder->andWhere($alias . '.october2011Raffle = 1');
    }
  }  
  
  public function handleSourceOfLeadFilter($queryBuilder, $alias, $field, $value)
  {
    if(!$value)
    {
      return;
    }

    $queryBuilder->andWhere($alias . '.SourceOfLead = :source');
    $queryBuilder->setParameter('source', $value);
  }
  
  public function handleLeadTypeFilter($queryBuilder, $alias, $field, $value)
  {
    if(!$value)
    {
      return;
    }

    $queryBuilder->andWhere($alias . '.leadType = :type');
    $queryBuilder->setParameter('type', $value);
  }

  public function handleLeadStatusFilter($queryBuilder, $alias, $field, $value)
  {
    if(!$value)
    {
      return;
    }

    $queryBuilder->andWhere($alias . '.leadStatus = :status');
    $queryBuilder->setParameter('status', $value);
  }

  public function handleCheckboxChoiceFilter($queryBuilder, $alias, $field, $value)
  {
    if(!$value)
    {
      return;
    }

    $queryBuilder->andWhere($alias . '.' . $value . ' = 1');
  }

  public function handleCountyDataFilter($queryBuilder, $alias, $field, $value)
  {
    if(!$value)
    {
      return;
    }

    $queryBuilder->leftJoin(sprintf('%s.enteredBy', $alias), 'u');
    $queryBuilder->andWhere('u.county = :county');
    $queryBuilder->setParameter('county', $value);
  }

  
  public function initializeDefaultFilters()
  {
      $this->filterDefaults['dataCounty'] = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser()->getCounty();
  }
  
    
  
  // View ======================================================================
  // ===========================================================================
  public $viewChoiceParentFields = array(
      'motivationChoiceComfort' => 'Motivation for making energy upgrades',
      'campaignChoiceTalkingToNeighbors' => 'Interested in helping with campaign?',
      'newsletterChoiceEnergyTips' => 'Interested in receiving monthly newsletters?',
      'financeChoiceHomeEquity' => 'Project Finance Preference',
  );
  public $viewFieldsToIndent = array(
      'primaryPhoneType' => true,
      'secondaryPhoneType' => true,
      'GJGNYReferenceOther' => true,
      'step1aActionsTaken' => true,
      'step2aInterested' => true,
      'step2bSubmitted' => true,
      'step2cScheduled' => true,
      'step2dCompleted' => true,
      'step3aContractor' => true,
      'step3bWorkDone' => true,
      'step3cHowFinanced' => true,
      'electricUtilityAcct' => true,
      'gasUtilityAcct' => true,
      'otherFuelSupplierType' => true,
      'otherFuelSupplierTypeOther' => true,
      'otherFuelSupplierAcct' => true,
      'motivationChoiceComfort' => true,
      'motivationChoiceMoney' => true,
      'motivationChoiceIndoorAir' => true,
      'motivationChoiceEnvironment' => true,
      'motivationChoiceOther' => true,
      'campaignChoiceTalkingToNeighbors' => true,
      'campaignChoiceFormEnergyTeam' => true,
      'campaignChoiceAppearInVideo' => true,
      'campaignChoiceShareExperience' => true,
      'newsletterChoiceEnergyTips' => true,
      'newsletterChoiceSavings' => true,
      'newsletterChoiceEvents' => true,
      'financeChoiceHomeEquity' => true,
      'financeChoiceGJGNY' => true,
      'financeChoicePocket' => true,
      'financeChoicePersonal' => true,
  );

  /*
   * There does not seem to be a way to specify the name/label of view items in $view or $viewGroups
   */
  public $viewLabels = array(
      'FirstName' => 'First Name',
      'middleInitial' => 'middle initial',
      'LastName' => 'Last Name',
      'county' => 'County',
      'SourceOfLead' => 'Source of Lead',
      'ProgramSource' => 'Program Source',
      'DateOfLead' => 'Date of First Contact',
      'leadType' => 'Type of Lead',
      'leadStatus' => 'Lead Status',
      'leadReferral' => 'Referral / Nomination',
      'CommunityGroupsConnectedTo' => 'Community groups connected to',
      'barriers' => 'Barriers to making upgrades',
      'interestedInVisit' => 'Interested in scheduling a home visit',
      'phone' => 'Phone',
      'primaryPhoneType' => 'type',
      'secondaryPhone' => 'Secondary Phone',
      'secondaryPhoneType' => 'type',
      'personalEmail' => 'Personal E-mail',
      'workEmail' => 'Work E-mail',
      'website' => 'Website',
      'organization' => 'Employer / Organization',
      'orgTitle' => 'Title',
      'orgAddress' => 'Address',
      'orgCity' => 'City',
      'orgState' => 'State',
      'orgZip' => 'Zip',
      'orgCounty' => 'County',
      'motivationChoiceComfort' => 'comfort',
      'motivationChoiceMoney' => 'money',
      'motivationChoiceIndoorAir' => 'indoor air quality',
      'motivationChoiceEnvironment' => 'environment',
      'motivationChoiceOther' => 'other',
      'campaignChoiceTalkingToNeighbors' => 'Talking to neighbors',
      'campaignChoiceFormEnergyTeam' => 'Forming an energy team',
      'campaignChoiceAppearInVideo' => 'Appearing in testimonial video',
      'campaignChoiceShareExperience' => 'Sharing experience with others',
      'newsletterChoiceEnergyTips' => 'Energy saving tips',
      'newsletterChoiceSavings' => 'Energy saving programs and incentives',
      'newsletterChoiceEvents' => 'Upcoming workshops and events',
      'otherNotes' => 'Other Notes',
      'step1' => '1. Low Cost / No Cost',
      'step1aActionsTaken' => '1a. actions taken',
      'step2' => '2. Energy Assessment',
      'step2aInterested' => '2a. interested in getting assessment',
      'step2bSubmitted' => '2b. GJGNY application submitted',
      'step2cScheduled' => '2c. Assessment scheduled',
      'step2dCompleted' => '2d. Assessment completed and report received',
      'step3' => '3. Whole house upgrade',
      'step3aContractor' => '3a. Name of contractor',
      'step3bWorkDone' => '3b. What was done',
      'step3cHowFinanced' => '3c. How was it financed',
      'step4' => '4. Upgrade Appliances',
      'step5' => '5. Renewable Energy',
      'hasCentralAC' => 'Has Central AC',
      'incomeRange' => 'Income Range',
      'buildingType' => 'Building Type',
      'sqFootage' => 'Above Grade Conditioned Square Footage',
      'financeChoiceHomeEquity' => 'Home equity loan',
      'financeChoiceGJGNY' => 'GJGNY loan',
      'financeChoicePocket' => 'Out-of-pocket',
      'financeChoicePersonal' => 'Personal loan',
      'GJGNYReference' => 'How did you hear about the GJGNY program',
      'GJGNYReferenceOther' => 'other',
      'electricUtility' => 'Electric Utility',
      'electricUtilityAcct' => 'account #',
      'gasUtility' => 'Gas Utility',
      'gasUtilityAcct' => 'account #',
      'otherFuelSupplier' => 'Other Fuel Supplier',
      'otherFuelSupplierType' => 'type',
      'otherFuelSupplierTypeOther' => 'other type',
      'otherFuelSupplierAcct' => 'account #',
      'pledge' => 'Pledge',
      'visitPeriod' => 'Visit Period',
      'BECCTeam' => 'BECC Team',
      'rank' => 'Rank',
      'enteredBy' => 'Data Entered By',
      'datetimeEntered' => 'Data Entered: ',
      'lastUpdatedBy' => 'Data Last Updated By',
      'datetimeLastUpdated' => 'Data Last Updated:',
      'DateOfNextFollowup' => 'Date of next Follow-up',
      'october2011Raffle' => 'October 2011 Raffle'
  );
  protected $view = array(
      'FirstName',
      'middleInitial',
      'LastName',
      'Address',
      'City',
      'State',
      'Zip',
      'Town',
      'county',
      'phone',
      'primaryPhoneType',
      'secondaryPhone',
      'secondaryPhoneType',
      'personalEmail',
      'workEmail',
      'website',
      'SourceOfLead',
      'ProgramSource',
      'DateOfLead',
      'leadReferral',
      'leadType',
      'leadStatus',
      'DateOfNextFollowup',
      'enteredBy',
      'datetimeEntered',
      'lastUpdatedBy',
      'datetimeLastUpdated',
      'organization',
      'orgTitle',
      'orgAddress',
      'orgCity',
      'orgState',
      'orgZip',
      'orgCounty',
      'CommunityGroupsConnectedTo',
      'barriers',
      'interestedInVisit',
      'motivationChoiceComfort', 'motivationChoiceMoney', 'motivationChoiceIndoorAir', 'motivationChoiceEnvironment', 'motivationChoiceOther',
      'campaignChoiceTalkingToNeighbors', 'campaignChoiceFormEnergyTeam', 'campaignChoiceAppearInVideo', 'campaignChoiceShareExperience',
      'newsletterChoiceEnergyTips', 'newsletterChoiceSavings', 'newsletterChoiceEvents',
      'otherNotes',
      'step1',
      'step1aActionsTaken',
      'step2',
      'step2aInterested', 'step2bSubmitted', 'step2cScheduled', 'step2dCompleted',
      'step3',
      'step3aContractor', 'step3bWorkDone', 'step3cHowFinanced',
      'step4',
      'step5',
      'hasCentralAC',
      'incomeRange',
      'buildingType',
      'sqFootage',
      'financeChoiceHomeEquity', 'financeChoiceGJGNY', 'financeChoicePocket', 'financeChoicePersonal',
      'GJGNYReference', 'GJGNYReferenceOther',
      'electricUtility', 'electricUtilityAcct',
      'gasUtility', 'gasUtilityAcct',
      'otherFuelSupplier',
      'otherFuelSupplierType',
      'otherFuelSupplierTypeOther',
      'otherFuelSupplierAcct',
      'pledge',
        'visitPeriod',
        'BECCTeam',
        'rank',
      'october2011Raffle',
      'LeadEvents' // NOTE: does not show up on form, the object is needed to generate links to the LeadEvents admin  actions
  );
  public $viewGroups = array(
      'Lead Information' => array(
          'fields' => array(
              'FirstName',
              'middleInitial',
              'LastName',
              'Address',
              'City',
              'State',
              'Zip',
              'Town',
              'county',
              'phone',
              'primaryPhoneType',
              'secondaryPhone',
              'secondaryPhoneType',
              'personalEmail',
              'workEmail',
              'enteredBy',
              'datetimeEntered',
              'lastUpdatedBy',
              'datetimeLastUpdated',
          )
      ),
      'Lead History' => array (
          'fields' => array (
              'SourceOfLead',
              'ProgramSource',
              'leadReferral',
              'DateOfLead',
              'leadType',
              'leadStatus',
              'DateOfNextFollowup'
           )
      ),
      'Employer / Organization Information' => array(
          'fields' => array(
              'organization',
              'orgTitle',
              'orgAddress',
              'orgCity',
              'orgState',
              'orgZip',
              'orgCounty',
              'website',              
          )
      ),
      'Other Information' => array(
          'fields' => array(
              'CommunityGroupsConnectedTo',
              'barriers',
              'interestedInVisit',
              'motivationChoiceComfort', 'motivationChoiceMoney', 'motivationChoiceIndoorAir', 'motivationChoiceEnvironment', 'motivationChoiceOther',
              'campaignChoiceTalkingToNeighbors', 'campaignChoiceFormEnergyTeam', 'campaignChoiceAppearInVideo', 'campaignChoiceShareExperience',
              'newsletterChoiceEnergyTips', 'newsletterChoiceSavings', 'newsletterChoiceEvents',
              'otherNotes',
          )
      ),
      'Energy Path Steps' => array(
          'fields' => array(
              'step1',
              'step1aActionsTaken',
              'step2',
              'step2aInterested', 'step2bSubmitted', 'step2cScheduled', 'step2dCompleted',
              'step3',
              'step3aContractor', 'step3bWorkDone', 'step3cHowFinanced',
              'step4',
              'step5'
          )
      ),
      'Broome Fields' => array(
          'fields' => array(
              'pledge',
              'visitPeriod',
              'BECCTeam',
              'rank'
          ),
      ),
      'Tompkins Fields' => array (
          'fields' => array(
              'october2011Raffle'
          ),
      ),
      'GJGNY Application Data' => array(
          'fields' => array(
              'hasCentralAC',
              'incomeRange',
              'buildingType',
              'sqFootage',
              'financeChoiceHomeEquity', 'financeChoiceGJGNY', 'financeChoicePocket', 'financeChoicePersonal',
              'GJGNYReference', 'GJGNYReferenceOther',
              'electricUtility', 'electricUtilityAcct',
              'gasUtility', 'gasUtilityAcct',
              'otherFuelSupplier',
              'otherFuelSupplierType',
              'otherFuelSupplierTypeOther',
              'otherFuelSupplierAcct'
          ),
          'collapsed' => true
      )
  );

  public function prePersist($Lead)
  {
    $Lead->setDatetimeEntered(new \DateTime());
    $Lead->setDatetimeLastUpdated(new \DateTime());
    $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
    $Lead->setEnteredBy($user);
    $Lead->setLastUpdatedBy($user);
    $Lead->setDataCounty($user->getCounty());
    
    parent::prePersist($Lead);
  }

  public function preUpdate($Lead)
  {
    $Lead->setDatetimeLastUpdated(new \DateTime());
    $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
    $Lead->setLastUpdatedBy($user);

    parent::preUpdate($Lead);
  }

}
