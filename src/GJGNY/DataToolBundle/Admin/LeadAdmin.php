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
use GJGNY\DataToolBundle\Admin\LeadEventAdmin as LeadEventAdmin;

class LeadAdmin extends Admin
{

    protected $maxPerPage = 10;
    protected $classnameLabel = 'Leads';
    protected $entityLabel = 'Lead';
    protected $entityLabelPlural = 'Leads';
    protected $entityIconPath = 'images/icons/Lead.png';

    // Form ======================================================================
    // ===========================================================================
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Lead Information')
                ->add('FirstName', null, array('label' => 'First Name', 'required' => false))
                ->add('middleInitial', null, array('label' => 'middle initial', 'required' => false))
                ->add('LastName', null, array('label' => 'Last Name', 'required' => false))
                ->add('Address', null, array('required' => false))
                ->add('City', null, array('label' => 'City (mailing address)', 'required' => false))
                ->add('State', 'choice', array(
                    'label' => 'State',
                    'required' => false,
                    'choices' => Lead::getStateChoices(),
                    'preferred_choices' => array('NY')
                ))
                ->add('Zip', null, array('required' => false))
                ->add('Town', null, array('required' => false))
                ->add('county', null, array('required' => false))
                ->add('phone', null, array('required' => false))
                ->add('primaryPhoneType', null, array('label' => 'type', 'required' => false))
                ->add('secondaryPhone', null, array('label' => 'Secondary Phone', 'required' => false))
                ->add('secondaryPhoneType', null, array('label' => 'type', 'required' => false))
                ->add('personalEmail', null, array('label' => 'Personal E-mail', 'required' => false))
                ->add('workEmail', null, array('label' => 'Work E-mail', 'required' => false))
            ->end()
            ->with('Lead History')
                ->add('SourceOfLead', 'choice', array('required' => false, 'label' => 'Source of Lead', 'choices' => Lead::getSourceOfLeadChoices()))
                ->add('ProgramSource', null, array('required' => false, 'label' => 'Program Source'))
                ->add('leadReferral', null, array('required' => false, 'label' => 'Referral / Nomination'))
                ->add('DateOfLead', null, array('label' => 'Date of First Contact', 'required' => false))
                ->add('leadType', 'choice', array('required' => false, 'label' => 'Type of Lead', 'choices' => Lead::getLeadTypeChoices()))
                ->add('leadStatus', 'choice', array('required' => false, 'label' => 'Lead Status', 'choices' => Lead::getLeadStatusChoices()))
                ->add('DateOfNextFollowup', null, array('label' => 'Date of next Follow-up', 'required' => false))
            ->end()
            ->with('Employer / Organization Information')
                ->add('organization', null, array('label' => 'Employer / Organization', 'required' => false))
                ->add('orgTitle', null, array('label' => 'Title', 'required' => false))
                ->add('orgAddress', null, array('label' => 'Address', 'required' => false))
                ->add('orgCity', null, array('label' => 'City', 'required' => false))
                ->add('orgState', 'choice', array(
                    'label' => 'State',
                    'required' => false,
                   'choices' => Lead::getStateChoices(),
                    'preferred_choices' => array('NY')
                        ), array('type' => 'choice'))
                ->add('orgZip', null, array('label' => 'Zip', 'required' => false))
                ->add('orgCounty', null, array('label' => 'County', 'required' => false))
                ->add('website', null, array('required' => false))
            ->end()
            ->with('Other Information')
                ->add('CommunityGroupsConnectedTo', null, array('label' => 'Community groups connected to', 'required' => false))
                ->add('barriers', null, array('label' => 'Barriers to making upgrades', 'required' => false))
                ->add('interestedInVisit', null, array('label' => 'Interested in scheduling a home visit', 'required' => false))

                ->add('motivationChoiceComfort', null, array('label' => 'Comfort', 'required' => false))
                ->add('motivationChoiceMoney', null, array('label' => 'Money', 'required' => false))
                ->add('motivationChoiceIndoorAir', null, array('label' => 'Indoor air quality', 'required' => false))
                ->add('motivationChoiceEnvironment', null, array('label' => 'Environment', 'required' => false))
                ->add('motivationChoiceOther', null, array('label' => 'Other', 'required' => false))

                ->add('campaignChoiceTalkingToNeighbors', null, array('label' => 'Talking to neighbors', 'required' => false))
                ->add('campaignChoiceFormEnergyTeam', null, array('label' => 'Forming an energy team', 'required' => false))
                ->add('campaignChoiceAppearInVideo', null, array('label' => 'Appear in testimonial video', 'required' => false))
                ->add('campaignChoiceShareExperience', null, array('label' => 'Share upgrade experience with others', 'required' => false))

                ->add('newsletterChoiceEnergyTips', null, array('label' => 'Energy saving tips', 'required' => false))
                ->add('newsletterChoiceSavings', null, array('label' => 'Energy saving programs and incentives', 'required' => false))
                ->add('newsletterChoiceEvents', null, array('label' => 'Upcoming workshops and events', 'required' => false))

                ->add('otherNotes', null, array('label' => 'Other Notes', 'required' => false))
            ->end()
            ->with('Energy Path steps')    
                ->add('step1', null, array('label' => 'Low cost / no-cost actions and tune up energy users', 'required' => false))
                ->add('step1aActionsTaken', null, array('label' => 'List specific actions taken', 'required' => false))
                ->add('step2', null, array('label' => 'Energy Assessment', 'required' => false))
                ->add('step2aInterested', null, array('label' => 'Interested in getting assessment', 'required' => false))
                ->add('step2bSubmitted', null, array('label' => 'GJGNY application submitted', 'required' => false))
                ->add('step2cScheduled', null, array('label' => 'Assessment scheduled', 'required' => false))
                ->add('step2dCompleted', null, array('label' => 'Assessment completed and report received', 'required' => false))
                ->add('step3', null, array('label' => 'Whole house upgrade', 'required' => false))
                ->add('step3aContractor', null, array('label' => 'Name of contractor', 'required' => false))
                ->add('step3bWorkDone', null, array('label' => 'What was done (air sealing, insulating, upgrade heating system, etc.)', 'required' => false))
                ->add('step3cHowFinanced', 'choice', array('required' => false, 'label' => 'How was it financed', 'choices' => Lead::getHowAssessmentFinancedChoices()))
                ->add('step4', null, array('label' => 'Upgrade Appliances', 'required' => false))
                ->add('step5', null, array('label' => 'Renewable energy', 'required' => false))
            ->end()
            ->with('Broome Fields')
                ->add('pledge', null, array('label' => 'Pledge', 'required' => false))
                ->add('visitPeriod', null, array('label' => 'Visit Period', 'required' => false))
                ->add('BECCTeam', null, array('label' => 'BECC Team', 'required' => false))
                ->add('rank', null, array('label' => 'Rank', 'required' => false))
            ->end()
            ->with('Tompkins Fields')
                ->add('october2011Raffle', null, array('label' => 'October 2011 Raffle', 'required' => false))
            ->end()
            ->with('GJGNY Application Fields')
                ->add('hasCentralAC', null, array('label' => 'Central AC?', 'required' => false))

                ->add('incomeRange', 'choice', array('required' => false, 'label' => 'Household Income Range', 'choices' => Lead::getIncomeRangeChoices()))
                ->add('buildingType', 'choice', array('label' => 'Building Type', 'choices' => Lead::getBuildingTypeChoices(), 'required' => false))
                ->add('sqFootage', null, array('label' => 'Above grade conditioned square footage', 'required' => false))

                ->add('financeChoiceHomeEquity', null, array('label' => 'Home Equity loan', 'required' => false))
                ->add('financeChoiceGJGNY', null, array('label' => 'GJGNY load', 'required' => false))
                ->add('financeChoicePocket', null, array('label' => 'Out-of-pocker', 'required' => false))
                ->add('financeChoicePersonal', null, array('label' => 'Personal loan', 'required' => false))

                ->add('GJGNYReference', 'choice', array('required' => false, 'label' => 'How did Lead hear about GJGNY program?', 'choices' => Lead::getGJGNYReferenceChoices()))
                ->add('GJGNYReferenceOther', null, array('label' => 'Other', 'required' => false))

                ->add('electricUtility', null, array('label' => 'Electric Utility', 'required' => false))
                ->add('electricUtilityAcct', null, array('label' => 'Electric Utility Acct #', 'required' => false))
                ->add('gasUtility', null, array('label' => 'Gas Utility', 'required' => false))
                ->add('gasUtilityAcct', null, array('label' => 'Gas Utility Acct #', 'required' => false))
                ->add('otherFuelSupplier', null, array('label' => 'Other Fuel Supplier', 'required' => false))
                ->add('otherFuelSupplierType', 'choice', array('label' => 'Other Fuel Supplier Type', 'choices' => Lead::getOtherFuelSupplierTypeChoices(), 'required' => false))
                ->add('otherFuelSupplierTypeOther', null, array('label' => 'Other type', 'required' => false))
                ->add('otherFuelSupplierAcct', null, array('label' => 'Other Fuel Supplier Acct #', 'required' => false))
            ->end()
      ;
    }

    /*
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
    );*/
    
    // List ======================================================================
    // ===========================================================================
    public $listPreHook = 'GJGNYDataToolBundle:Lead:_listPreHook.html.twig';

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('LastName', 'string', array('label' => 'Name','template' => 'GJGNYDataToolBundle:Lead:_name.html.twig'))
                ->add('Contact', 'string', array('template' => 'GJGNYDataToolBundle:Lead:_contact.html.twig'))
                ->add('Address', null, array('template' => 'GJGNYDataToolBundle:Lead:_address.html.twig'))
                
                ->add('SourceOfLead', null, array('label' => 'Source of Lead'))
                ->add('ProgramSource', null, array('label' => 'Program Source'))
                ->add('DateOfLead', null, array('label' => 'Date of First Contact', 'template' => 'GJGNYDataToolBundle:Lead:_dateOfLead.html.twig'))

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
        $datagrid->add('FirstName', null, array('label' => 'First name'));
        $datagrid->add('LastName', null, array('label' => 'Last name'));
        $datagrid->add('City');
        $datagrid->add('Zip');
        $datagrid->add('SourceOfLead', 'doctrine_orm_choice', array(
            'label' => 'Source of Lead',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getSourceOfLeadChoices()
            ),
            'field_type' => 'choice'
        ));
        $datagrid->add('ProgramSource', null, array('label' => 'Program Source'));
        $datagrid->add('leadType', 'doctrine_orm_choice', array(
            'label' => 'Type of Lead',
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getLeadTypeChoices()
            )
        ));
        $datagrid->add('leadStatus', 'doctrine_orm_choice', array(
            'label' => 'Lead Status',
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getLeadStatusChoices()
            )
        ));
        $datagrid->add('dataCounty', 'doctrine_orm_callback', array(
            'label' => 'County Data',
            'callback' => function($queryBuilder, $alias, $field, $values){
                if(!$values['value'])
                {
                    return;
                }

                $queryBuilder->leftJoin(sprintf('%s.enteredBy', $alias), 'u');
                $queryBuilder->andWhere('u.county = :county');
                $queryBuilder->setParameter('county', $values['value']);
            },
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => array('Broome' => 'Broome', 'Tompkins' => 'Tompkins')
            )
        ));
        $datagrid->add('personalEmail', null, array('label' => 'Personal E-mail'));
        $datagrid->add('workEmail', null, array('label' => 'Work E-mail'));
        $datagrid->add('organization', null, array('label' => 'Work / Organization'));
        $datagrid->add('Motivation', 'doctrine_orm_callback', array(
            'label' => 'Motivation for upgrade',
            'callback' => array($this, 'handleCheckboxChoiceFilter'),
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getMotivationChoices()
            )
        ));
        $datagrid->add('Campaign', 'doctrine_orm_callback', array(
            'label' => 'Capaign interest',
            'callback' => array($this, 'handleCheckboxChoiceFilter'),
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getCampaignChoices()
            )
        ));
        $datagrid->add('Newsletter', 'doctrine_orm_callback', array(
            'label' => 'Newsletter interest',
            'callback' => array($this, 'handleCheckboxChoiceFilter'),
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getNewsletterChoices()
            )
        ));
        $datagrid->add('PathStep', 'doctrine_orm_callback', array(
            'label' => 'Energy Path Step',
            'callback' => array($this, 'handleCheckboxChoiceFilter'),
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getStepChoices()
            )
        ));
        $datagrid->add('october2011Raffle', 'doctrine_orm_callback', array(
            'label' => '10/11 Raffle',
            'callback' => function($queryBuilder, $alias, $field, $values) {
                if(!$values['value'])
                {
                    return;
                }
                if($values['value'] == 'true')
                {
                    $queryBuilder->andWhere($alias . '.october2011Raffle = 1');
                }
            },
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => array('true' => 'true')
            )
        ));

        $this->initializeDefaultFilters();
    }

    public function handleCheckboxChoiceFilter($queryBuilder, $alias, $field, $values)
    {
        if(!$values['value'])
        {
            return;
        }

        $queryBuilder->andWhere($alias . '.' . $values['value'] . ' = 1');
    }


    public function initializeDefaultFilters()
    {
       $this->filterDefaults['dataCounty'] = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser()->getCounty();
    }
    public $hiddenFilters = array(
        'personalEmail' => true,
        'workEmail' => true,
        'organization' => true,
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


    // Show ======================================================================
    // ===========================================================================
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Lead Information')
                ->add('FirstName', null, array('label' => 'First Name'))
                ->add('middleInitial', null, array('label' => 'middle initial'))
                ->add('LastName', null, array('label' => 'Last Name'))
                ->add('Address')
                ->add('City')
                ->add('State')
                ->add('Zip')
                ->add('Town')
                ->add('county', null, array('label' => 'County'))
                ->add('phone', null, array('label' => 'Phone'))
                ->add('primaryPhoneType', null, array('label' => 'type'))
                ->add('secondaryPhone', null, array('label' => 'Secondary Phone'))
                ->add('secondaryPhoneType', null, array('label' => 'type'))
                ->add('personalEmail', null, array('label' => 'Personal E-mail'))
                ->add('workEmail', null, array('label' => 'Work E-mail'))
            ->end()
            ->with('Lead History')
                ->add('SourceOfLead', null, array('label' => 'Source of Lead'))
                ->add('ProgramSource', null, array('label' => 'Program Source'))
                ->add('leadReferral', null, array('label' => 'Lead Referral'))
                ->add('DateOfLead', null, array('label' => 'Date of Lead'))
                ->add('leadType', null, array('label' => 'Type of Lead'))
                ->add('leadStatus', null, array('label' => 'Lead Status'))
                ->add('DateOfNextFollowup', null, array('label' => 'Date of next followup'))
            ->end()
            ->with('Employer / Organization Information')
                ->add('organization', null, array('label' => 'Organization'))
                ->add('orgTitle', null, array('label' => 'Title'))
                ->add('orgAddress', null, array('label' => 'Address'))
                ->add('orgCity', null, array('label' => 'City'))
                ->add('orgState', null, array('label' => 'State'))
                ->add('orgZip', null, array('label' => 'Zip'))
                ->add('orgCounty', null, array('label' => 'County'))
                ->add('website', null, array('label' => 'Website'))
            ->end()
            ->with('Other Information')
                ->add('CommunityGroupsConnectedTo', null, array('label' => 'Community groups connected to'))
                ->add('barriers', null, array('label' => 'Barriers to making upgrades'))
                ->add('interestedInVisit', null, array('label' => 'Interested in scheduling a home visit'))
                ->add('motivationChoiceComfort', null, array('label' => 'comfort'))
                ->add('motivationChoiceMoney', null, array('label' => 'money'))
                ->add('motivationChoiceIndoorAir', null, array('label' => 'indoor air quality'))
                ->add('motivationChoiceEnvironment', null, array('label' => 'environment'))
                ->add('motivationChoiceOther', null, array('label' => 'other'))
                ->add('campaignChoiceTalkingToNeighbors', null, array('label' => 'Talking to neighbors'))
                ->add('campaignChoiceFormEnergyTeam', null, array('label' => 'Forming an energy team'))
                ->add('campaignChoiceAppearInVideo', null, array('label' => 'Appearing in testimonial video'))
                ->add('campaignChoiceShareExperience', null, array('label' => 'Sharing experience with others'))
                ->add('newsletterChoiceEnergyTips', null, array('label' => 'Energy saving tips'))
                ->add('newsletterChoiceSavings', null, array('label' => 'Energy saving programs and incentives'))
                ->add('newsletterChoiceEvents', null, array('label' => 'Upcoming workshops and events'))
                ->add('otherNotes', null, array('label' => 'Other Notes'))
                ->add('enteredBy', null, array('label' => 'Entered By'))
                ->add('datetimeEntered', null, array('label' => 'Date Entered'))
                ->add('lastUpdatedBy', null, array('label' => 'Last Updated By'))
                ->add('datetimeLastUpdated', null, array('label' => 'Date Last Updated'))
            ->end()
            ->with('Enery Path Steps')
                ->add('step1', null, array('label' => '1. Low Cost / No Cost'))
                ->add('step1aActionsTaken', null, array('label' => '1a. actions taken'))
                ->add('step2', null, array('label' => '2. Energy Assessment'))
                ->add('step2aInterested', null, array('label' => '2a. interested in getting assessment'))
                ->add('step2bSubmitted', null, array('label' => '2b. GJGNY application submitted'))
                ->add('step2cScheduled', null, array('label' => '2c. Assessment scheduled'))
                ->add('step2dCompleted', null, array('label' => '2d. Assessmeny completed and report received'))
                ->add('step3', null, array('label' => '3. Whole house upgrade'))
                ->add('step3aContractor', null, array('label' => '3a. Name of contractor'))
                ->add('step3bWorkDone', null, array('label' => '3b. What was done?'))
                ->add('step3cHowFinanced', null, array('label' => '3c. How was it financed?'))
                ->add('step4', null, array('label' => '4. Upgrade Appliances'))
                ->add('step5', null, array('label' => '5. Renewable Energy'))
            ->end()
            ->with('Broome Fields')
                ->add('pledge', null, array('label' => 'Pledge'))
                ->add('visitPeriod', null, array('label' => 'Visit Period'))
                ->add('BECCTeam', null, array('label' => 'BECC Team'))
                ->add('rank', null, array('label' => 'Rank'))
            ->end()                
            ->with('Tompkins Fields')
                ->add('october2011Raffle', null, array('label' => 'October 2011 Raffle'))                
            ->end()
            ->with('GJGNY Application Fields')
                ->add('hasCentralAC', null, array('label' => 'Has Central AC'))
                ->add('incomeRange', null, array('label' => 'Income Range'))
                ->add('buildingType', null, array('label' => 'Building Type'))
                ->add('sqFootage', null, array('label' => 'Above Grade Conditioned Square Footage'))
                ->add('financeChoiceHomeEquity', null, array('label' => 'Home equity loan'))
                ->add('financeChoiceGJGNY', null, array('label' => 'GJGNY loan'))
                ->add('financeChoicePocket', null, array('label' => 'Out-of-pocket'))
                ->add('financeChoicePersonal', null, array('label' => 'Personal loan'))
                ->add('GJGNYReference', null, array('label' => 'How did you hear about the GJGNY program?'))
                ->add('GJGNYReferenceOther', null, array('label' => 'other'))
                ->add('electricUtility', null, array('label' => 'Electric Utility'))
                ->add('electricUtilityAcct', null, array('label' => 'account #'))
                ->add('gasUtility', null, array('label' => 'Gas Utility'))
                ->add('gasUtilityAcct', null, array('label' => 'account #'))
                ->add('otherFuelSupplier', null, array('label' => 'Other Fuel Supplier'))
                ->add('otherFuelSupplierType', null, array('label' => 'type'))
                ->add('otherFuelSupplierTypeOther', null, array('label' => 'other type'))
                ->add('otherFuelSupplierAcct', null, array('label' => 'accounty #'))
            ->end()   
        ;
    }
        
    // may need to include LeadEvents in show to generate links to the LeadEvents admin actions
  
    /*public $viewChoiceParentFields = array(
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
    );*/
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
