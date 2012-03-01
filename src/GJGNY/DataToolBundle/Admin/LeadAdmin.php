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
    protected $entityIconPath = 'bundles/sonataadmin/famfamfam/group.png';

    // Form ======================================================================
    // ===========================================================================
    protected function configureFormFields(FormMapper $formMapper)
    {
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();

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
                ->add('DateOfLead', 'date', array('label' => 'Date of First Contact', 'required' => false, 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                ->add('needToCall', null, array('label' => 'Need to Call'))
                ->add('leadStatus', 'choice', array('required' => false, 'label' => 'Lead Status', 'choices' => Lead::getLeadStatusChoices()))
                ->add('DateOfNextFollowup', null, array('label' => 'Date of next Follow-up', 'required' => false, 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                ->add('enteredBy', 'sonata_type_model', array('label' => 'Entered By', 'required' => false), array('edit' => 'standard'))
            ->end()
            ->setHelps(array(
                'DateOfNextFollowup' => 'Lead will be marked "need to call" on this date'
            ))
            ->with('Lead Type')
                ->add('leadTypeUpgrade', null, array('label' => 'Energy Upgrade', 'required' => false))
                ->add('leadTypeOutreach', null, array('label' => 'Outreach', 'required' => false))
                ->add('leadTypeWorkforce', null, array('label' => 'Workforce', 'required' => false))
                ->add('leadCategory', 'choice', array('label' => "Category", 'required' => false, 'choices' => Lead::getLeadCategoryChoices()))
                ->add('homeowner', null, array('label' => 'Homeowner', 'required' => false))
                ->add('renter', null, array('label' => 'Renter', 'required' => false))
                ->add('landlord', null, array('label' => 'Landlord', 'required' => false))
            ->end()
            ->with('Energy Upgrade Status')    
                ->add('step2aInterested', null, array('label' => 'Interested in Home Energy assessment', 'required' => false))
                ->add('step2bSubmitted', null, array('label' => 'GJGNY application submitted', 'required' => false))
                ->add('step2dCompleted', null, array('label' => 'Assessment Complete', 'required' => false))
                    ->add('dateOfAssessment', null, array('label' => 'Date', 'required' => false, 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                ->add('reportReceived', null, array('label' => 'Report Received', 'required' => false))
                ->add('scopeOfWorkSubmitted', null, array('label' => 'Scope of Work Submitted', 'required' => false))
                ->add('step3', null, array('label' => 'Upgrade Complete', 'required' => false))
                    ->add('dateOfUpgrade', null, array('label' => 'Date', 'required' => false, 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                    ->add('step3aContractor', null, array('label' => 'Name of contractor', 'required' => false))
                    ->add('step3bWorkDone', null, array('label' => 'What was done (air sealing, insulating, upgrade heating system, etc.)', 'required' => false))
                    ->add('step3cHowFinanced', 'choice', array('required' => false, 'label' => 'How was it financed', 'choices' => Lead::getHowAssessmentFinancedChoices()))
                ->add('CRISStatus', 'choice', array('label' => 'CRIS Status', 'required' => false, 'choices' => Lead::getCRISStatusChoices()))
                ->add('upgradeStatusNotes', null, array('label' => 'Notes', 'required' => false))
            ->end()
            ->with('Outreach')
                ->add('CommunityGroupsConnectedTo', null, array('label' => 'Community groups connected to', 'required' => false))
                ->add('campaignChoiceTalkingToNeighbors', null, array('label' => 'talking to neighbors', 'required' => false))
                ->add('campaignChoiceFormEnergyTeam', null, array('label' => 'forming an energy team', 'required' => false))
                ->add('campaignChoiceAppearInVideo', null, array('label' => 'appearing in testimonial video', 'required' => false))
                ->add('campaignChoiceShareExperience', null, array('label' => 'sharing upgrade experience with others', 'required' => false))
                ->add('campaignChoiceVolunteer', null, array('label' => 'becoming a volunteer', 'required' => false))
                ->add('campaignChoiceSteward', null, array('label' => 'becoming a senion energy steward', 'required' => false))
                ->add('campaignChoiceEvent', null, array('label' => 'presenting at an event', 'required' => false))
                ->add('campaignChoiceOther', null, array('label' => 'other', 'required' => false))
                ->add('otherNotes', null, array('label' => 'Other Notes', 'required' => false))
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
            ->end();
        
        if($user->getCounty() == "Broome") {
            $formMapper
                ->with('Other Fields', array('collapsed' => true))
                    ->add('pledge', null, array('label' => 'Pledge', 'required' => false))
                    ->add('postPledge', null, array('label' => 'Post-upgrade Pledge', 'required' => false))
                    ->add('interestedInVisit', null, array('label' => 'Interested in scheduling a home visit', 'required' => false))
                    ->add('visitPeriod', null, array('label' => 'Visit Period', 'required' => false))
                    ->add('BECCTeam', null, array('label' => 'BECC Team', 'required' => false))
                    ->add('rank', null, array('label' => 'Rank', 'required' => false))
                    ->add('leadReferral', null, array('required' => false, 'label' => 'Referral / Nomination'))
                ->end();
        } else if($user->getCounty() == "Tompkins") {
            $formMapper
                ->with('Other Fields', array('collapsed' => true))
                    ->add('october2011Raffle', null, array('label' => 'October 2011 Raffle', 'required' => false))
                ->end();
        }
      
    }
   
    public $fieldGroupsToCheckForDuplicates = array (
        array('FirstName', 'LastName'),
        array('Address')
    );
    
    public $formFieldPreHooks = array(
        // "other" fields
        'primaryPhoneType' => 'SonataAdminBundle:Hook:_otherFormFieldPre.html.twig',
        'motivationChoiceOther' => 'SonataAdminBundle:Hook:_otherFormFieldPre.html.twig',
        'secondaryPhoneType' => 'SonataAdminBundle:Hook:_otherFormFieldPre.html.twig',
        'campaignChoiceOther' => 'SonataAdminBundle:Hook:_otherFormFieldPre.html.twig',

        // indented fields
        'dateOfAssessment' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'dateOfUpgrade' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'reportReceived' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'scopeOfWorkSubmitted' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'step3aContractor' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'step3bWorkDone' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'step3cHowFinanced' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'renter' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'landlord' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        
        // indent choice options
        // NOTE: the indent divs for the first choices are included in the field group label hooks below
        'campaignChoiceFormEnergyTeam' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'campaignChoiceAppearInVideo' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'campaignChoiceShareExperience' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'campaignChoiceVolunteer' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'campaignChoiceSteward' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'campaignChoiceEvent' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'leadTypeOutreach' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'leadTypeWorkforce' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
 
        // field group labels
       'campaignChoiceTalkingToNeighbors' => 'GJGNYDataToolBundle:Lead:_campaignChoiceFormPreHook.html.twig',
       'homeowner' => 'GJGNYDataToolBundle:Lead:_homeownerFormPreHook.html.twig',
       'leadTypeUpgrade' => 'GJGNYDataToolBundle:Lead:_leadTypeUpgradeFormPreHook.html.twig'        
    );
    
    public $formFieldPostHooks = array(
        // "other" fields
        'primaryPhoneType' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'secondaryPhoneType' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceOther' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        
        // indented fields
        'dateOfAssessment' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'dateOfUpgrade' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'reportReceived' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'scopeOfWorkSubmitted' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'step3aContractor' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'step3bWorkDone' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'step3cHowFinanced' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'homeowner' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'renter' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'landlord' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        
         // choice options
        'campaignChoiceTalkingToNeighbors' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceFormEnergyTeam' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceAppearInVideo' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceShareExperience' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceVolunteer' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceSteward' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceEvent' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'leadTypeUpgrade' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'leadTypeOutreach' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'leadTypeWorkforce' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
    );
    
    public $formPostHook = array(
        'template' => 'GJGNYDataToolBundle:Lead:_editPostHook.html.twig',
    );

    
    // List ======================================================================
    // ===========================================================================
    public $listPreHook = array('template' => 'GJGNYDataToolBundle:Lead:_listPreHook.html.twig');

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
        $datagrid->add('Program', 'doctrine_orm_callback', array(
            'label' => 'Program Source',
            'callback' => function($queryBuilder, $alias, $field, $values) {
                if(!$values['value'])
                {
                    return;
                }
                if(!$values['value'] || $values['value'] == "")
                {
                    return;
                }
                $queryBuilder->leftjoin($alias.'.Program', 'p');
                $queryBuilder->andWhere('p.name = :programSource');
                $queryBuilder->setParameter('programSource',$values['value']);
                
            },
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => $this->getProgramSourceChoices()
            )
        ));        $datagrid->add('leadStatus', 'doctrine_orm_choice', array(
            'label' => 'Lead Status',
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getLeadStatusChoices()
            )
        ));
        $datagrid->add('needToCall', null, array('label' => 'Need to Call'));
        $datagrid->add('dataCounty', 'doctrine_orm_choice', array(
            'label' => 'Outreach County',
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => array('Broome' => 'Broome', 'Tompkins' => 'Tompkins')
            )
        ));
        $datagrid->add('personalEmail', null, array('label' => 'Personal E-mail'));
        $datagrid->add('workEmail', null, array('label' => 'Work E-mail'));
        $datagrid->add('organization', null, array('label' => 'Work / Organization'));
        $datagrid->add('Campaign', 'doctrine_orm_callback', array(
            'label' => 'Campaign interest',
            'callback' => array($this, 'handleCheckboxChoiceFilter'),
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getCampaignChoices()
            )
        ));
        $datagrid->add('step2aInterested', null, array('label' => 'Interested in Assessment'));
        $datagrid->add('step2bSubmitted', null, array('label' => 'GJGNY Application Submitted'));
        $datagrid->add('reportReceived', null, array('label' => 'Report Received'));
        $datagrid->add('step2dCompleted', null, array('label' => 'Assessment Complete'));
        $datagrid->add('dateOfAssessment', 'doctrine_orm_date_range', array('label' => 'Date of Assessment'));
        $datagrid->add('step3', null, array('label' => 'Upgrade Complete'));
        $datagrid->add('dateOfUpgrade', 'doctrine_orm_date_range', array('label' => 'Date of Upgrade'));
        
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
        $datagrid->add('leadEventTitle', 'doctrine_orm_callback', array(
            'label' => 'Has Event with Title',
            'callback' => function($queryBuilder, $alias, $field, $values) {
                if(!$values['value'] || $values['value'] == "")
                {
                    return;
                }
                $queryBuilder->leftjoin($alias.'.LeadEvents', 'le');
                $queryBuilder->andWhere('le.description = :eventTitle');
                $queryBuilder->setParameter('eventTitle',$values['value']);
            },
            'field_type' => 'choice',                    
            'field_options' => array(
                'required' => false,
                'choices' => $this->configurationPool->getContainer()->get('gjgny.datatool.admin.leadevent')->getDescriptionChoices()
            )
        ));
        $datagrid->add('leadType', 'doctrine_orm_callback', array(
            'label' => 'Type of Lead',
            'callback' => array($this, 'handleCheckboxChoiceFilter'),
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getLeadTypeChoices()
            )
        ));            
        $datagrid->add('leadCategory', 'doctrine_orm_choice', array(
            'label' => 'Lead Category',
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getLeadCategoryChoices()
            )
        ));            
        $datagrid->add('homeowner', null, array('label' => 'Homeowner'));
        $datagrid->add('renter', null, array('label' => 'Renter'));
        $datagrid->add('landlord', null, array('label' => 'Landlord'));
        
        // leave the dates for last since they are tall
        $datagrid->add('DateOfLead', 'doctrine_orm_date_range', array('label' => 'Date of First Contact'));
        $datagrid->add('DateOfNextFollowup', 'doctrine_orm_date_range', array('label' => 'Date of Next Follow-up'));
        $datagrid->add('datetimeEntered', 'doctrine_orm_date_range', array('label' => 'Date Entered'));
        
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
        'Campaign' => true,
        'PathStep' => true,
        'october2011Raffle' => true,
        'DateOfLead' => true,
        'DateOfNextFollowup' => true,
        'leadCategory',
        'homeowner' => true,
        'renter' => true,
        'landlord' => true,
        'commercial' => true,
        'multifamily' => true,
        'datetimeEntered' => true,
        'step2aInterested' => true,
        'step2bSubmitted' => true,
        'reportReceived' => true,
        'step2dCompleted' => true,
        'step3' => true,
        'dateOfUpgrade' => true,
        'dateOfAssessment' => true,
        'leadCategory' => true,
        'leadEventTitle' => true
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
            ->add('needToCall', null, array('label' => 'Need to Call', 'type' => 'boolean'))                
            ->add('DateOfNextFollowup', array('label' => 'Date of next Follow-up', 'type' => 'date'))
            
            ->add('leadTypeUpgrade', array('label' => 'Lead Type: Energy Upgrade', 'type' => 'boolean'))
            ->add('leadTypeOutreach', array('label' => 'Lead Type: Outreach', 'type' => 'boolean'))
            ->add('leadTypeWorkforce', array('label' => 'Lead Type: Workforce', 'type' => 'boolean'))
            ->add('leadCategory', array('label' => 'Lead Category'))
            ->add('homeowner', array('label' => 'Homeowner', 'type' => 'boolean'))
            ->add('renter', array('label' => 'Renter', 'type' => 'boolean'))
            ->add('landlord', array('label' => 'Landlord', 'type' => 'boolean'))
            ->add('otherNotes', array('label' => 'Other Notes'))                
                
            ->add('organization', array('label' => 'Employer / Organization'))
            ->add('orgTitle', array('label' => 'Org Title'))
            ->add('orgAddress', array('label' => 'Org Address'))
            ->add('orgCity', array('label' => 'Org City'))
            ->add('orgState', array('label' => 'Org State'))
            ->add('orgZip', array('label' => 'Org Zip'))
            ->add('orgCounty', array('label' => 'Org County'))
            ->add('website', array('label' => 'Org Website'))
            
            ->add('CommunityGroupsConnectedTo', array('label' => 'Community groups connected to'))
            ->add('interestedInVisit', array('label' => 'Interested in scheduling a home visit', 'type' => 'boolean'))            
            ->add('campaignChoiceTalkingToNeighbors', array('label' => 'Campaign interest: talking to neighbors', 'type' => 'boolean'))
            ->add('campaignChoiceFormEnergyTeam', array('label' => 'Campaign interest: forming an energy team', 'type' => 'boolean'))
            ->add('campaignChoiceAppearInVideo', array('label' => 'Campaign interest: appearing in testimonial video', 'type' => 'boolean'))
            ->add('campaignChoiceShareExperience', array('label' => 'Campaign interest: sharing upgrade experience with others', 'type' => 'boolean'))
            ->add('campaignChoiceVolunteer', array('label' => 'Campaign interest: becoming a volunteer', 'type' => 'boolean'))
            ->add('campaignChoiceSteward', array('label' => 'Campaign interest: becoming an energy steward', 'type' => 'boolean'))
            ->add('campaignChoiceEvent', array('label' => 'Campaign interest: presenting at event', 'type' => 'boolean'))
            ->add('campaignChoiceOther', array('label' => 'Campaign interest other'))
    
            ->add('step2aInterested', array('label' => 'Interested in assessment', 'type' => 'boolean'))
            ->add('step2bSubmitted', array('label' => 'GJGNY application submitted', 'type' => 'boolean'))
            ->add('step2dCompleted', array('label' => 'Assessment completed', 'type' => 'boolean'))
            ->add('dateOfAssessment', array('label' => 'Date of Assessment', 'type' => 'date'))
            ->add('scopeOfWorkSubmitted', array('label' => 'Scope of Work Submitted'))
            ->add('step3', array('label' => 'Upgrade Complete', 'type' => 'boolean'))
            ->add('dateOfUpgrade', array('label' => 'Date of Upgrade', 'type' => 'date'))
            ->add('step3aContractor', array('label' => 'Name of contractor'))
            ->add('step3bWorkDone', array('label' => 'What was done?'))
            ->add('step3cHowFinanced', array('label' => 'How was it financed'))
            ->add('CRISStatus', array('label' => 'CRIS Status'))
                

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
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();

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
                ->add('DateOfLead', null, array('label' => 'Date of Lead'))
                ->add('needToCall', null, array('label' => 'Need to Call'))
                ->add('leadStatus', null, array('label' => 'Lead Status'))
                ->add('DateOfNextFollowup', null, array('label' => 'Date of next followup'))
            ->end()
            ->with('Lead Type')
                ->add('leadTypeUpgrade', null, array('label' => 'Energy Upgrade'))
                ->add('leadTypeOutreach', null, array('label' => 'Outreach'))
                ->add('leadTypeWorkforce', null, array('label' => 'Workforce'))
                ->add('leadCategory', null, array('label' => 'Lead Category'))
                ->add('homeowner', null, array('label' => 'Homeowner'))
                ->add('renter', null, array('label' => 'Renter'))
                ->add('landlord', null, array('label' => 'Landlord'))
            ->end()
            ->with('Enery Upgrade Status')
                ->add('step2aInterested', null, array('label' => 'Interested in Home Energy Assessment'))
                ->add('step2bSubmitted', null, array('label' => 'GJGNY Application Submitted'))
                ->add('step2dCompleted', null, array('label' => 'Assessment Complete'))
                ->add('dateOfAssessment', null, array('label' => 'Date'))
                ->add('reportReceived', null, array('label' => 'Report Received'))
                ->add('scopeOfWorkSubmitted', null, array('label' => 'Scope of Work Submitted'))
                ->add('step3', null, array('label' => 'Upgrade Complete'))
                ->add('dateOfUpgrade', null, array('label' => 'Date'))
                ->add('step3aContractor', null, array('label' => 'Name of contractor'))
                ->add('step3bWorkDone', null, array('label' => 'What was done?'))
                ->add('step3cHowFinanced', null, array('label' => 'How was it financed?'))
                ->add('upgradeStatusNotes', null, array('label' => 'Notes'))
                ->add('CRISStatus', null, array('label' => 'CRIS Status'))
            ->end()
            ->with('Outreach')
                ->add('CommunityGroupsConnectedTo', null, array('label' => 'Community groups connected to'))
                ->add('campaignChoiceTalkingToNeighbors', null, array('label' => 'Campaign Interest: talking to neighbors'))
                ->add('campaignChoiceFormEnergyTeam', null, array('label' => 'Campaign Interest: forming an energy team'))
                ->add('campaignChoiceAppearInVideo', null, array('label' => 'Campaign Interest: appearing in testimonial video'))
                ->add('campaignChoiceShareExperience', null, array('label' => 'Campaign Interest: sharing experience with others'))
                ->add('campaignChoiceVolunteer', null, array('label' => 'Campaign Interest: becoming a volunteer'))
                ->add('campaignChoiceSteward', null, array('label' => 'Campaign Interest: becoming an energy steward'))
                ->add('campaignChoiceEvent', null, array('label' => 'Campaign Interest: presentating at an event'))
                ->add('campaignChoiceOther', null, array('label' => 'Campaign Interest: other'))
                ->add('otherNotes', null, array('label' => 'Other Notes'))                
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
            ->with('Workforce Fields')
                ->add('highestLevelOfEducation', null, array('label' => 'Highest Level of Education'))
                ->add('certifications', null, array('label' => 'Certifications'))
                ->add('trainingExperience', null, array('label' => 'Training Experience'))                
            ->end();
        
        if($user->getCounty() == "Broome") {
            $showMapper
                ->with('Other Fields')
                    ->add('pledge', null, array('label' => 'Pledge'))
                    ->add('postPledge', null, array('label' => 'Post Upgrade Pledge'))
                    ->add('interestedInVisit', null, array('label' => 'Interested in scheduling a home visit'))
                    ->add('visitPeriod', null, array('label' => 'Visit Period'))
                    ->add('BECCTeam', null, array('label' => 'BECC Team'))
                    ->add('rank', null, array('label' => 'Rank'))
                    ->add('leadReferral', null, array('label' => 'Lead Referral'))
                ->end();
        } else if($user->getCounty() == "Tompkins") {
            $showMapper
                ->with('Other Fields')
                    ->add('october2011Raffle', null, array('label' => 'October 2011 Raffle'))                
                ->end();
        }
        
        $showMapper
            ->with('Entry Information')
                ->add('enteredBy', null, array('label' => 'Entered By'))
                ->add('datetimeEntered', null, array('label' => 'Date Entered'))
                ->add('lastUpdatedBy', null, array('label' => 'Last Updated By'))
                ->add('datetimeLastUpdated', null, array('label' => 'Date Last Updated'))
                ->add('uploadedViaXLS', 'boolean', array('label' => 'Uploaded via Spreadsheet'))
            ->end()
        ;
        
        $this->initializeShowHooks();
    }
        
    public $hideEmptyShowFields = true;
    public $hideableShowFieldBlacklist = array (
        'step2aInterested',
        'step2bSubmitted',
        'step2dCompleted',
        'step3'
    );

    public $showPreHook = array(
        'template' => 'GJGNYDataToolBundle:Lead:_showPreHook.html.twig',
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
        
        'dateOfAssessment' => 'indented',
        'dateOfUpgrade' => 'indented',
        'step3aContractor' => 'indented',
        'step3bWorkDone' => 'indented',
        'step3cHowFinanced' => 'indented',
        'scopeOfWorkSubmitted' => 'indented',
        'reportReceived' => 'indented',
    );
    
    public function prePersist($Lead)
    {
        $Lead->setDatetimeEntered(new \DateTime());
        $Lead->setDatetimeLastUpdated(new \DateTime());
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
        if(!$Lead->getEnteredBy()) $Lead->setEnteredBy($user); // could be set in form
        $Lead->setLastUpdatedBy($user);        
        if(!$Lead->getDataCounty()) $Lead->setDataCounty($user->getCounty()); // could be set in spreadsheet import

        parent::prePersist($Lead);
    }
    
    public function preUpdate($Lead)
    {
        $Lead->setDatetimeLastUpdated(new \DateTime());
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
        $Lead->setLastUpdatedBy($user);

        parent::preUpdate($Lead);
    }
    
    public function getProgramSourceChoices()
    {
        $programSourceChoices = array();
        $em = $this->configurationPool->getContainer()->get('doctrine')->getEntityManager();
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();

        $programQuery = $em->createQuery(
            'SELECT p.name, p.id FROM GJGNYDataToolBundle:Program p WHERE p.dataCounty=:county ORDER BY p.name ASC'
        )->setParameter('county', $user->getCounty());
        
        $programs = $programQuery->getResult();
                
        foreach($programs as $p)
        {
            if(isset($p['name']) && trim($p['name']) != "") {
                $programSourceChoices[$p['name']] = $p['name'];                
            }
        }
       
        return $programSourceChoices;
    }

}
