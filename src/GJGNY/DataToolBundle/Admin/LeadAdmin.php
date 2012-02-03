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
            ->with('Contact Information')
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
                ->add('Program', 'sonata_type_model', array('label' => 'Program Source', 'required' => false), array('edit' => 'standard'))
                ->add('SourceOfLead', 'choice', array('required' => false, 'label' => 'Source of Lead', 'choices' => Lead::getSourceOfLeadChoices()))
                ->add('leadReferral', null, array('required' => false, 'label' => 'Referral / Nomination'))
                ->add('DateOfLead', null, array('label' => 'Date of First Contact', 'required' => false, 'widget' => 'choice', 'format' => 'MM/dd/yyyy'))
                ->add('leadStatus', 'choice', array('required' => false, 'label' => 'Lead Status', 'choices' => Lead::getLeadStatusChoices()))
                ->add('DateOfNextFollowup', null, array('label' => 'Date of next Follow-up', 'required' => false, 'widget' => 'choice', 'format' => 'MM/dd/yyyy'))
            ->end()
            ->setHelps(array(
                'Program' => 'An Lead Event will automatically be created for the selected program',
                'SourceOfLead' => 'If e-mail or phone a Lead Event will automatically be created.',
                'leadStatus' => 'Your team will receive e-mail updates about Leads with the status "need to call".',
                'DateOfNextFollowup' => 'This is the date your team will start receiving e-mail updates if your Lead\'s status is "awaiting follow up"'
            ))
            ->with('Other Information')
                ->add('leadTypeUpgrade', null, array('label' => 'Energy Upgrade', 'required' => false))
                ->add('leadTypeOutreach', null, array('label' => 'Outreach', 'required' => false))
                ->add('leadTypeWorkforce', null, array('label' => 'Workforce', 'required' => false))
                ->add('homeowner', null, array('label' => 'Homeowner', 'required' => false))
                ->add('renter', null, array('label' => 'Renter', 'required' => false))
                ->add('landlord', null, array('label' => 'Landlord', 'required' => false))
                ->add('interestedInVisit', null, array('label' => 'Interested in scheduling a home visit', 'required' => false))
                ->add('CommunityGroupsConnectedTo', null, array('label' => 'Community groups connected to', 'required' => false))
                ->add('barriers', null, array('label' => 'Barriers to making upgrades', 'required' => false))

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
                ->add('step1', null, array('label' => '1. Low cost / no-cost actions and tune up energy users', 'required' => false))
                ->add('step1aActionsTaken', null, array('label' => '1a. List specific actions taken', 'required' => false))
                ->add('step2', null, array('label' => '2. Energy Assessment', 'required' => false))
                ->add('step2aInterested', null, array('label' => '2a. Interested in getting assessment', 'required' => false))
                ->add('step2bSubmitted', null, array('label' => '2b. GJGNY application submitted', 'required' => false))
                ->add('step2cScheduled', null, array('label' => '2c. Assessment scheduled', 'required' => false))
                ->add('step2dCompleted', null, array('label' => '2d. Assessment completed and report received', 'required' => false))
                ->add('step3', null, array('label' => '3. Whole house upgrade', 'required' => false))
                ->add('step3aContractor', null, array('label' => '3a. Name of contractor', 'required' => false))
                ->add('step3bWorkDone', null, array('label' => '3b. What was done (air sealing, insulating, upgrade heating system, etc.)', 'required' => false))
                ->add('step3cHowFinanced', 'choice', array('required' => false, 'label' => '3c. How was it financed', 'choices' => Lead::getHowAssessmentFinancedChoices()))
                ->add('step4', null, array('label' => '4. Upgrade Appliances', 'required' => false))
                ->add('step5', null, array('label' => '5. Renewable energy', 'required' => false))
            ->end()
            ->with('Employer / Organization Information', array('collapsed' => true))
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
            ->with('Workforce Fields', array('collapsed' => true))
                ->add('highestLevelOfEducation', 'choice', array('label' => 'Highest Level of Education', 'required' => false, 'choices' => Lead::getHighestLevelOfEducationChoices()))
                ->add('certifications', null, array('label' => 'Certifications', 'required' => false))
                ->add('trainingExperience', null, array('label' => 'Training Experience', 'required' => false))                
            ->end()
            ->with('Broome Fields', array('collapsed' => true))
                ->add('pledge', null, array('label' => 'Pledge', 'required' => false))
                ->add('visitPeriod', null, array('label' => 'Visit Period', 'required' => false))
                ->add('BECCTeam', null, array('label' => 'BECC Team', 'required' => false))
                ->add('rank', null, array('label' => 'Rank', 'required' => false))
            ->end()
            ->with('Tompkins Fields', array('collapsed' => true))
                ->add('october2011Raffle', null, array('label' => 'October 2011 Raffle', 'required' => false))
            ->end()
            ->with('GJGNY Application Fields', array('collapsed' => true))
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
   
    public $fieldGroupsToCheckForDuplicates = array (
        array('FirstName', 'LastName'),
        array('Address')
    );
    
    public $formFieldPreHooks = array(
        // "other" fields
        'primaryPhoneType' => 'SonataAdminBundle:Hook:_otherFormFieldPre.html.twig',
        'motivationChoiceOther' => 'SonataAdminBundle:Hook:_otherFormFieldPre.html.twig',
        'GJGNYReferenceOther' => 'SonataAdminBundle:Hook:_otherFormFieldPre.html.twig',
        'otherFuelSupplierTypeOther' => 'SonataAdminBundle:Hook:_otherFormFieldPre.html.twig',
        'secondaryPhoneType' => 'SonataAdminBundle:Hook:_otherFormFieldPre.html.twig',
        
        // indented fields
        'step1aActionsTaken' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'step2aInterested' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'step2bSubmitted' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'step2cScheduled' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'step2dCompleted' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'step3aContractor' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'step3bWorkDone' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'step3cHowFinanced' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        
        // indent choice options
        // NOTE: the indent divs for the first choices are included in the field group label hooks below
        'motivationChoiceMoney' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'motivationChoiceIndoorAir' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'motivationChoiceEnvironment' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'motivationChoiceOther' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'campaignChoiceFormEnergyTeam' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'campaignChoiceAppearInVideo' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'campaignChoiceShareExperience' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'newsletterChoiceSavings' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'newsletterChoiceEvents' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'financeChoiceGJGNY' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'financeChoicePocket' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'financeChoicePersonal' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'leadTypeOutreach' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'leadTypeWorkforce' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
 
        // field group labels
       'financeChoiceHomeEquity' => 'GJGNYDataToolBundle:Lead:_financeChoiceFormPreHook.html.twig',
       'newsletterChoiceEnergyTips' => 'GJGNYDataToolBundle:Lead:_newsletterChoiceFormPreHook.html.twig',
       'campaignChoiceTalkingToNeighbors' => 'GJGNYDataToolBundle:Lead:_campaignChoiceFormPreHook.html.twig',
       'motivationChoiceComfort' => 'GJGNYDataToolBundle:Lead:_motivationChoiceFormPreHook.html.twig',
       'leadTypeUpgrade' => 'GJGNYDataToolBundle:Lead:_leadTypeUpgradeFormPreHook.html.twig'        
    );
    
    public $formFieldPostHooks = array(
        // "other" fields
        'primaryPhoneType' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'motivationChoiceOther' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'GJGNYReferenceOther' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'otherFuelSupplierTypeOther' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'secondaryPhoneType' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        
        // indented fields
        'step1aActionsTaken' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'step2aInterested' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'step2bSubmitted' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'step2cScheduled' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'step2dCompleted' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'step3aContractor' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'step3bWorkDone' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'step3cHowFinanced' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        
         // choice options
        'motivationChoiceComfort' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'motivationChoiceMoney' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'motivationChoiceIndoorAir' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'motivationChoiceEnvironment' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'motivationChoiceOther' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceTalkingToNeighbors' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceFormEnergyTeam' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceAppearInVideo' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceShareExperience' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'newsletterChoiceEnergyTips' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'newsletterChoiceSavings' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'newsletterChoiceEvents' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'financeChoiceHomeEquity' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'financeChoiceGJGNY' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'financeChoicePocket' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'financeChoicePersonal' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'leadTypeUpgrade' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'leadTypeOutreach' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'leadTypeWorkforce' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
    );
    
    public $formPostHook = array(
        'template' => 'GJGNYDataToolBundle:Lead:_editPostHook.html.twig',
    );

    
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
                ->add('Program', null, array('label' => 'Program Source'))
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
        $datagrid->add('county');
        $datagrid->add('SourceOfLead', 'doctrine_orm_choice', array(
            'label' => 'Source of Lead',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getSourceOfLeadChoices()
            ),
            'field_type' => 'choice'
        ));
        $datagrid->add('Program', null, array('label' => 'Program Source'));
        $datagrid->add('leadType', 'doctrine_orm_callback', array(
            'label' => 'Type of Lead',
            'callback' => array($this, 'handleCheckboxChoiceFilter'),
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
        $datagrid->add('dataCounty', 'doctrine_orm_choice', array(
            'label' => 'County Data',
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
            'label' => 'Campaign interest',
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
        $datagrid->add('step2aInterested', null, array('label' => 'Step 2a. Interested in Assessment'));
        $datagrid->add('step2bSubmitted', null, array('label' => 'Step 2b. Application Submitted'));
        $datagrid->add('step2dCompleted', null, array('label' => 'Step 2a. Assessment Complete'));
        $datagrid->add('step3', null, array('label' => 'Step 3. Upgrade'));
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
        $datagrid->add('homeowner', null, array('label' => 'Homeowner'));
        $datagrid->add('renter', null, array('label' => 'Renter'));
        $datagrid->add('landlord', null, array('label' => 'Landlord'));

        // leave the dates for last since they are tall
        $datagrid->add('DateOfLead', 'doctrine_orm_date_range', array('label' => 'Date of First Contact'));
        $datagrid->add('DateOfNextFollowup', 'doctrine_orm_date_range', array('label' => 'Date of Next Follow-up'));
        $datagrid->add('datetimeEntered', 'doctrine_orm_date_range', array('label' => 'Date Entered'));
        $datagrid->add('ELPincomplete', null);
        $datagrid->add('step2Or3', 'doctrine_orm_callback', array(
            'label' => 'Step 2 or 3',
            'callback' => function($queryBuilder, $alias, $field, $values) {
                if(!$values['value'])
                {
                    return;
                }
                $queryBuilder->andWhere(
                        $alias.'.step2 = :value OR '.
                        $alias.'.step3 = :value OR '.
                        $alias.'.step2aInterested = :value OR '.
                        $alias.'.step2bSubmitted = :value OR '.
                        $alias.'.step2cScheduled = :value OR '.
                        $alias.'.step2dCompleted = :value');
                
                if($values['value'] == 'yes') {
                    $queryBuilder->setParameter('value','1');
                } else {
                    $queryBuilder->setParameter('value','0');                    
                }

            },
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => array('yes' => 'yes', 'no' => 'no')
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
        'october2011Raffle' => true,
        'DateOfLead' => true,
        'DateOfNextFollowup' => true,
        'homeowner' => true,
        'renter' => true,
        'landlord' => true,
        'datetimeEntered' => true,
        'step2aInterested' => true,
        'step2bSubmitted' => true,
        'step2dCompleted' => true,
        'step3' => true,
        'ELPincomplete' => true,
        'step2Or3' => true
    );

    protected function configureSpreadsheetFields(SpreadsheetMapper $spreadsheetMapper)
    {
        $spreadsheetMapper
            ->add('FirstName', array('label' => 'First Name'))
            ->add('middleInitial', array('label' => 'middle initial'))
            ->add('LastName', array('label' => 'Last Name'))
            ->add('Address', array('required' => false))
            ->add('City', array('label' => 'City (mailing address)'))
            ->add('State')
            ->add('Zip')
            ->add('Town')
            ->add('county')
            ->add('phone', array('label' => 'Primary Phone'))
            ->add('primaryPhoneType', array('label' => 'primary phone type'))
            ->add('secondaryPhone', array('label' => 'Secondary Phone'))
            ->add('secondaryPhoneType', array('label' => 'secondary phone type'))
            ->add('personalEmail', array('label' => 'Personal E-mail'))
            ->add('workEmail', array('label' => 'Work E-mail'))
            
            ->add('SourceOfLead', array('label' => 'Source of Lead'))
            ->add('Program', array('label' => 'Program Source','type' => 'relation', 'relation_field_name' => 'Program_id', 'relation_repository' => 'GJGNYDataToolBundle:Program'))
            ->add('leadReferral', array('label' => 'Referral / Nomination'))
            ->add('DateOfLead', array('label' => 'Date of First Contact', 'type' => 'date'))
            ->add('leadStatus', array('label' => 'Lead Status'))
            ->add('DateOfNextFollowup', array('label' => 'Date of next Follow-up', 'type' => 'date'))
            
            ->add('organization', array('label' => 'Employer / Organization'))
            ->add('orgTitle', array('label' => 'Org Title'))
            ->add('orgAddress', array('label' => 'Org Address'))
            ->add('orgCity', array('label' => 'Org City'))
            ->add('orgState', array('label' => 'Org State'))
            ->add('orgZip', array('label' => 'Org Zip'))
            ->add('orgCounty', array('label' => 'Org County'))
            ->add('website', array('label' => 'Org Website'))
            
            ->add('CommunityGroupsConnectedTo', array('label' => 'Community groups connected to'))
            ->add('barriers', array('label' => 'Barriers to making upgrades'))
            ->add('interestedInVisit', array('label' => 'Interested in scheduling a home visit', 'type' => 'boolean'))            
            ->add('homeowner', array('label' => 'Homeowner'))
            ->add('renter', array('label' => 'Renter'))
            ->add('landlord', array('label' => 'Landlord'))
            ->add('otherNotes', array('label' => 'Other Notes'))
            ->add('leadTypeUpgrade', array('label' => 'Lead Type: Energy Upgrade', 'type' => 'boolean'))
            ->add('leadTypeOutreach', array('label' => 'Lead Type: Outreach', 'type' => 'boolean'))
            ->add('leadTypeWorkforce', array('label' => 'Lead Type: Workforce', 'type' => 'boolean'))

            ->add('motivationChoiceComfort', array('label' => 'Motivation for upgrades: Comfort', 'type' => 'boolean'))
            ->add('motivationChoiceMoney', array('label' => 'Motivation for upgrades: Money', 'type' => 'boolean'))
            ->add('motivationChoiceIndoorAir', array('label' => 'Motivation for upgrades: Indoor air quality', 'type' => 'boolean'))
            ->add('motivationChoiceEnvironment', array('label' => 'Motivation for upgrades: Environment', 'type' => 'boolean'))
            ->add('motivationChoiceOther', array('label' => 'Motivation for upgrades: Other'))

            ->add('campaignChoiceTalkingToNeighbors', array('label' => 'Campaign interest: Talking to neighbors', 'type' => 'boolean'))
            ->add('campaignChoiceFormEnergyTeam', array('label' => 'Campaign interest: Forming an energy team', 'type' => 'boolean'))
            ->add('campaignChoiceAppearInVideo', array('label' => 'Campaign interest: Appear in testimonial video', 'type' => 'boolean'))
            ->add('campaignChoiceShareExperience', array('label' => 'Campaign interest: Share upgrade experience with others', 'type' => 'boolean'))

            ->add('newsletterChoiceEnergyTips', array('label' => 'Newsletter interest: Energy saving tips', 'type' => 'boolean'))
            ->add('newsletterChoiceSavings', array('label' => 'Newsletter interest: Energy saving programs and incentives', 'type' => 'boolean'))
            ->add('newsletterChoiceEvents', array('label' => 'Newsletter interest: Upcoming workshops and events', 'type' => 'boolean'))

                
            ->add('step1', array('label' => '1. Low cost / no-cost actions and tune up energy users', 'type' => 'boolean'))
            ->add('step1aActionsTaken', array('label' => '1a. List specific actions taken'))
            ->add('step2', array('label' => '2. Energy Assessment', 'type' => 'boolean'))
            ->add('step2aInterested', array('label' => '2a. Interested in getting assessment', 'type' => 'boolean'))
            ->add('step2bSubmitted', array('label' => '2b. GJGNY application submitted', 'type' => 'boolean'))
            ->add('step2cScheduled', array('label' => '2c. Assessment scheduled', 'type' => 'boolean'))
            ->add('step2dCompleted', array('label' => '2d. Assessment completed and report received', 'type' => 'boolean'))
            ->add('step3', array('label' => '3. Whole house upgrade', 'type' => 'boolean'))
            ->add('step3aContractor', array('label' => '3a. Name of contractor'))
            ->add('step3bWorkDone', array('label' => '3b. What was done (air sealing, insulating, upgrade heating system, etc.)'))
            ->add('step3cHowFinanced', array('label' => '3c. How was it financed'))
            ->add('step4', array('label' => '4. Upgrade Appliances', 'type' => 'boolean'))
            ->add('step5', array('label' => '5. Renewable energy', 'type' => 'boolean'))
                

        ;
    }
    
    protected function configureSummaryFields(SummaryMapper $summaryMapper)
    {
        $summaryMapper
            ->addYField('SourceOfLead', array('label' => 'Source of Lead'))
            ->addYField('Program', array('label' => 'Program Source','type' => 'relation', 'relation_field_name' => 'Program_id', 'relation_repository' => 'GJGNYDataToolBundle:Program'))
            ->addYField('DateOfLead', array('label' => 'Date of First Contact', 'type' => 'date'))
            ->addXField('City')
            ->addXField('Zip')
        ;
    }

    // Show ======================================================================
    // ===========================================================================
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Contact Information')
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
                ->add('Program', null, array('label' => 'Program Source'))
                ->add('leadReferral', null, array('label' => 'Lead Referral'))
                ->add('DateOfLead', null, array('label' => 'Date of Lead'))
                ->add('leadStatus', null, array('label' => 'Lead Status'))
                ->add('DateOfNextFollowup', null, array('label' => 'Date of next followup'))
            ->end()
            ->with('Other Information')
                ->add('leadTypeUpgrade', null, array('label' => 'Energy Upgrade'))
                ->add('leadTypeOutreach', null, array('label' => 'Outreach'))
                ->add('leadTypeWorkforce', null, array('label' => 'Workforce'))
                ->add('CommunityGroupsConnectedTo', null, array('label' => 'Community groups connected to'))
                ->add('homeowner', null, array('label' => 'Homeowner'))
                ->add('renter', null, array('label' => 'Renter'))
                ->add('landlord', null, array('label' => 'Landlord'))
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
            ->with('Workforce Fields', array('collapsed' => true))
                ->add('highestLevelOfEducation', null, array('label' => 'Highest Level of Education'))
                ->add('certifications', null, array('label' => 'Certifications'))
                ->add('trainingExperience', null, array('label' => 'Training Experience'))                
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
        
        $this->initializeShowHooks();
    }
        
    public $showPreHook = array(
        'template' => 'GJGNYDataToolBundle:Lead:_leadEventLink.html.twig',
    );
        
    public $showFieldPreHooks = array (
        // extra labels for choice groups
        'motivationChoiceComfort' => 'GJGNYDataToolBundle:Lead:_motivationChoiceShowPreHook.html.twig',
        'campaignChoiceTalkingToNeighbors' => 'GJGNYDataToolBundle:Lead:_campaignChoiceShowPreHook.html.twig',
        'newsletterChoiceEnergyTips' => 'GJGNYDataToolBundle:Lead:_newsletterChoiceShowPreHook.html.twig',
        'financeChoiceHomeEquity' => 'GJGNYDataToolBundle:Lead:_financeChoiceShowPreHook.html.twig',
        'leadTypeUpgrade' => 'GJGNYDataToolBundle:Lead:_leadTypeUpgradeShowPreHook.html.twig',
    );
    
    public function initializeShowHooks()
    {
        $this->showPreHook['parameters'] = array(
            'LeadEventAdmin' =>  $this->configurationPool->getContainer()->get('gjgny.datatool.admin.leadevent')
        );
    }
    
    public $showFieldClasses = array (
        'primaryPhoneType' => 'indented',
        'secondaryPhoneType' => 'indented',
        'GJGNYReferenceOther' => 'indented',
        'step1aActionsTaken' => 'indented',
        'step2aInterested' => 'indented',
        'step2bSubmitted' => 'indented',
        'step2cScheduled' => 'indented',
        'step2dCompleted' => 'indented',
        'step3aContractor' => 'indented',
        'step3bWorkDone' => 'indented',
        'step3cHowFinanced' => 'indented',
        'electricUtilityAcct' => 'indented',
        'gasUtilityAcct' => 'indented',
        'otherFuelSupplierType' => 'indented',
        'otherFuelSupplierTypeOther' => 'indented',
        'otherFuelSupplierAcct' => 'indented',
        'motivationChoiceComfort' => 'indented',
        'motivationChoiceMoney' => 'indented',
        'motivationChoiceIndoorAir' => 'indented',
        'motivationChoiceEnvironment' => 'indented',
        'motivationChoiceOther' => 'indented',
        'campaignChoiceTalkingToNeighbors' => 'indented',
        'campaignChoiceFormEnergyTeam' => 'indented',
        'campaignChoiceAppearInVideo' => 'indented',
        'campaignChoiceShareExperience' => 'indented',
        'newsletterChoiceEnergyTips' => 'indented',
        'newsletterChoiceSavings' => 'indented',
        'newsletterChoiceEvents' => 'indented',
        'financeChoiceHomeEquity' => 'indented',
        'financeChoiceGJGNY' => 'indented',
        'financeChoicePocket' => 'indented',
        'financeChoicePersonal' => 'indented',
        'leadTypeUpgrade' => 'indented',
        'leadTypeOutreach' => 'indented',
        'leadTypeWorkforce' => 'indented',
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
    
    public function postPersist($Lead)
    {
        // automatically create lead acquisitions for some Leads
        if($Lead->getProgram() || $Lead->getSourceOfLead() == "Phone" || $Lead->getSourceOfLead() == "E-mail") {
            $LeadEvent = new \GJGNY\DataToolBundle\Entity\LeadEvent();
            $LeadEvent->setLead($Lead);
            
            $LeadEvent->setDatetimeEntered(new \DateTime());
            $LeadEvent->setDatetimeLastUpdated(new \DateTime());
            $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
            $LeadEvent->setEnteredBy($user);
            $LeadEvent->setLastUpdatedBy($user);
            
            if($Lead->getProgram()) {
                $LeadEvent->setDescription($Lead->getProgram()->getName());
            } else if($Lead->getSourceOfLead() == "Phone") {
                $LeadEvent->setDescription("phone call received");
            } else if($Lead->getSourceOfLead() == "E-mail") {
                $LeadEvent->setDescription("e-mail received");
            }
            
            
            $LeadEvent->setDate($Lead->getDateOfLead());
            $LeadEvent->setEventType("lead acquisition");
            
            
            $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getEntityManager();
            $em->persist($LeadEvent);
            $em->flush();
          
        }
		
        parent::postPersist($Lead);
    }

    public function preUpdate($Lead)
    {
        $Lead->setDatetimeLastUpdated(new \DateTime());
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
        $Lead->setLastUpdatedBy($user);

        parent::preUpdate($Lead);
    }

}
