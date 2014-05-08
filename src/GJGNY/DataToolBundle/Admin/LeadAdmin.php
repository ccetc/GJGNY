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
                ->add('countyEntity', 'sonata_type_model', array('required' => false, 'label' => 'County'))
                ->add('phone', null, array('required' => false))
                ->add('primaryPhoneType', null, array('label' => 'type', 'required' => false))
                ->add('secondaryPhone', null, array('label' => 'Secondary Phone', 'required' => false))
                ->add('secondaryPhoneType', null, array('label' => 'type', 'required' => false))
                ->add('personalEmail', null, array('label' => 'Personal E-mail', 'required' => false))
                ->add('workEmail', null, array('label' => 'Work E-mail', 'required' => false))
            ->end()
            ->with('Lead History')
                ->add('outreachOrganization', 'choice', array('required' => false, 'label' => 'Outreach Organization', 'choices' => Lead::getOutreachOrganizationChoices()))
                ->add('Program', 'sonata_type_model', array('label' => 'Program Source', 'required' => false), array('edit' => 'standard'))
                ->add('SourceOfLead', 'choice', array('required' => false, 'label' => 'Source of Lead', 'choices' => Lead::getSourceOfLeadChoices()))
                ->add('sourceOfLeadDetails', null, array('required' => false))
                ->add('appointmentMade', null, array('label' => 'Appointment Made'))
                ->add('dateOfNextAppointment', null, array('label' => 'Date of next appointment', 'required' => false, 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                ->add('DateOfLead', 'date', array('label' => 'Date of First Contact', 'required' => false, 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                ->add('needToCall', null, array('label' => 'Need to Contact'))
                ->add('leadStatus', 'choice', array('required' => false, 'label' => 'Lead Status', 'choices' => Lead::getLeadStatusChoices()))
                ->add('DateOfNextFollowup', null, array('label' => 'Date of next Follow-up', 'required' => false, 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                ->add('userAssignedTo', 'sonata_type_model', array('label' => 'Assigned To', 'required' => false), array('edit' => 'standard'))
            ->end()
            ->setHelps(array(
                'DateOfNextFollowup' => 'Lead will be marked "need to contact" on this date'
            ))
            ->with('Lead Type')
                ->add('leadTypeUpgrade', null, array('label' => 'Energy Upgrade', 'required' => false))
                ->add('leadTypeOutreach', null, array('label' => 'Outreach', 'required' => false))
                ->add('leadTypeWorkforce', null, array('label' => 'Workforce', 'required' => false))
                ->add('leadTypeSolar', null, array('label' => 'Solar', 'required' => false))
                ->add('category', 'choice', array('label' => "Category", 'required' => false, 'choices' => Lead::getCategoryChoices(), 'expanded' => true, 'multiple' => true ))
                ->add('solarTypePV', null, array('label' => 'PV', 'required' => false))
                ->add('solarTypeHotWater', null, array('label' => 'Hot Water', 'required' => false))
            ->end()
            ->with('Energy Upgrade')    
                ->add('upgradeStatus', 'choice', array('label' => 'Upgrade Status', 'required' => false, 'choices' => Lead::getUpgradeStatusChoices()))
                ->add('CRISStatus', 'choice', array('label' => 'CRIS Status', 'required' => false, 'choices' => Lead::getCRISStatusChoices()))
                ->add('step2eContractor', null, array('label' => 'Name of contractor', 'required' => false))
                ->add('dateAppSubmitted', null, array('label' => 'Date Application Submitted', 'required' => false, 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                ->add('dateAppApproved', null, array('label' => 'Date Application Approved', 'required' => false, 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                ->add('dateContractorSelected', null, array('label' => 'Date Contractor Selected', 'required' => false, 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                ->add('dateOfAssessment', null, array('label' => 'Date of Assessment', 'required' => false, 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                ->add('dateWorkScopeApproved', null, array('label' => 'Date Work Scope Approved', 'required' => false, 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                ->add('dateOfUpgrade', null, array('label' => 'Date of Upgrade', 'required' => false, 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                ->add('step3bWorkDone', null, array('label' => 'Description of work completed', 'required' => false))
                ->add('financeOnBill', null, array('label' => 'On-bill recovery loan', 'required' => false))
                ->add('financeAHP', null, array('label' => 'AHP', 'required' => false))
                ->add('financeEnergySmart', null, array('label' => 'Energy Smart (unsecured) loan', 'required' => false))
                ->add('financeHomeEquity', null, array('label' => 'home equity loan', 'required' => false))
                ->add('financePersonal', null, array('label' => 'personal loan', 'required' => false))
                ->add('financePocket', null, array('label' => 'out of pocket', 'required' => false))
                ->add('upgradeStatusNotes', null, array('label' => 'Notes', 'required' => false))
            ->end()
            ->with('Solar Upgrade')    
                ->add('solarUpgradeStatus', 'choice', array('label' => 'Solar Upgrade Status', 'expanded' => true, 'multiple' => true, 'required' => false, 'attr' => array('class' => 'stacked-options'), 'choices' => Lead::getSolarUpgradeStatusChoices()))
            ->end()
            ->with('Outreach')
                ->add('CommunityGroupsConnectedTo', null, array('label' => 'Community groups connected to', 'required' => false))
                ->add('campaignChoiceTalkingToNeighbors', null, array('label' => 'Give program flyer to neighbor or friends', 'required' => false))
                ->add('campaignChoiceFormEnergyTeam', null, array('label' => 'forming an energy team', 'required' => false))
                ->add('campaignChoiceAppearInVideo', null, array('label' => 'appear in a testimonial', 'required' => false))
                ->add('campaignChoicePresent', null, array('label' => 'set up presentation at workplace or organization', 'required' => false))
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

        $solarUpgradeStatusChoices = Lead::getSolarUpgradeStatusChoices();
        foreach(Lead::$solarDateMappings as $statusArrayKey => $fieldNumber)
        {
            $choice = $solarUpgradeStatusChoices[$statusArrayKey];
            $formMapper->with('Solar Upgrade')->add('solarDate'.$fieldNumber, null, array('label' => 'date '.$choice, 'required' => false, 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))->end();
        }            
        
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
        
        // indent choice options
        // NOTE: the indent divs for the first choices are included in the field group label hooks below
        'campaignChoiceFormEnergyTeam' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'campaignChoiceAppearInVideo' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'campaignChoicePresent' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'campaignChoiceVolunteer' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'campaignChoiceSteward' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'campaignChoiceEvent' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'leadTypeOutreach' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'leadTypeWorkforce' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',        
        'leadTypeSolar' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'financeEnergySmart' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'financeAHP' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'financeHomeEquity' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'financePersonal' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'financePocket' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',
        'solarTypeHotWater' => 'SonataAdminBundle:Hook:_indentFormFieldPre.html.twig',        
 
        // field group labels
       'financeOnBill' => 'GJGNYDataToolBundle:Lead:_financeFormPreHook.html.twig',
       'campaignChoiceTalkingToNeighbors' => 'GJGNYDataToolBundle:Lead:_campaignChoiceFormPreHook.html.twig',
       'leadTypeUpgrade' => 'GJGNYDataToolBundle:Lead:_leadTypeUpgradeFormPreHook.html.twig',        
       'solarTypePV' => 'GJGNYDataToolBundle:Lead:_solarTypePVFormPreHook.html.twig'        
    );
    
    public $formFieldPostHooks = array(
        // "other" fields
        'primaryPhoneType' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'secondaryPhoneType' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceOther' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
                
         // choice options
        'campaignChoiceTalkingToNeighbors' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceFormEnergyTeam' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceAppearInVideo' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoicePresent' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceVolunteer' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceSteward' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'campaignChoiceEvent' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'leadTypeUpgrade' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'leadTypeOutreach' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'leadTypeWorkforce' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'leadTypeSolar' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'financeOnBill' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'financeAHP' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'financeEnergySmart' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'financeHomeEquity' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'financePersonal' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'financePocket' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'solarTypePV' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
        'solarTypeHotWater' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
    );
    
    public $formPostHook = array(
        'template' => 'GJGNYDataToolBundle:Lead:_editPostHook.html.twig',
    );

    // List ======================================================================
    // ===========================================================================
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('assignLeads', 'assignLeads/{userToId}/{userFromId}');
        $collection->add('assignLeadsSelectUser', 'assignLeadsSelectUser');
    }

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
        
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
        $this->listActionButtons = array(
            array(
                'route' => 'list',
                'parameters' => array(
                    'filter[userAssignedTo][value]' => $user->getId()
                ),
                'text' => 'My Leads'
            ),
            array(
                'route' => 'assignLeadsSelectUser',
                'text' => 'Re-Assign Leads'
            )
        );
    }
    
    

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        $actions['transfer'] = array(
            'label' => 'Transfer selected to me',
            'ask_confirmation' => true
        );
        
        return array_reverse($actions);
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
        ));
        $datagrid->add('leadStatus', 'doctrine_orm_choice', array(
            'label' => 'Lead Status',
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getLeadStatusChoices()
            )
        ));
        $datagrid->add('upgradeStatus', 'doctrine_orm_choice', array(
            'label' => 'Upgrade Status',
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getUpgradeStatusChoices()
            )
        ));
        $datagrid->add('solarUpgradeStatus', 'doctrine_orm_callback', array(
            'label' => 'Solar Upgrade Status',
            'callback' => function ($queryBuilder, $alias, $field, $values) {
                if(!$values['value'])
                {
                    return;
                }

                $queryBuilder->andWhere($alias.'.solarUpgradeStatus LIKE :status');
                $queryBuilder->setParameter('status', '%' . $values['value'] . '%');
            },
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getSolarUpgradeStatusChoices()                
            ),
        ));
        $datagrid->add('needToCall', null, array('label' => 'Need to Contact'));
        $datagrid->add('dataCounty', null, array(
            'label' => 'Outreach County',
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => array('Broome' => 'Broome', 'Tompkins' => 'Tompkins'),
            ),
        ));
        $datagrid->add('outreachOrganization', 'doctrine_orm_choice', array(
            'label' => 'Outreach Organization',
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getOutreachOrganizationChoices()
            )
        ));
        $datagrid->add('personalEmail', 'doctrine_orm_callback', array(
            'label' => 'Email',
            'callback' => function ($queryBuilder, $alias, $field, $values) {
                if(!$values['value'])
                {
                    return;
                }

                $queryBuilder->andWhere($alias.'.personalEmail LIKE :email OR '.$alias.'.workEmail LIKE :email');
                $queryBuilder->setParameter('email', '%' . $values['value'] . '%');
            },
            'field_options' => array(
                'required' => false,
            ),
        ));
        $datagrid->add('phone', 'doctrine_orm_callback', array(
            'label' => 'Phone',
            'callback' => function ($queryBuilder, $alias, $field, $values) {
                if(!$values['value'])
                {
                    return;
                }

                $queryBuilder->andWhere($alias.'.phone LIKE :phone OR '.$alias.'.secondaryPhone LIKE :phone');
                $queryBuilder->setParameter('phone', '%' . $values['value'] . '%');
            },
            'field_options' => array(
                'required' => false,
            ),
        ));
        $datagrid->add('CRISStatus', 'doctrine_orm_choice', array(
            'label' => 'CRIS Status',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getCRISStatusChoices()
            ),
            'field_type' => 'choice'
        ));
	$datagrid->add('inCRIS', 'doctrine_orm_callback', array(
            'label' => 'in CRIS',
            'callback' => function($queryBuilder, $alias, $field, $values) {
                if(!$values['value']) {
                    return;
                }
                if($values['value'] == 'true') {
                    $queryBuilder->andWhere($alias . '.CRISStatus IS NOT NULL AND '.$alias.'.CRISStatus!=:emptyString');
                } else if($values['value'] == 'false'){
		    $queryBuilder->andWhere($alias . '.CRISStatus IS NULL OR '.$alias.'.CRISStatus=:emptyString');
		}
                $queryBuilder->setParameter('emptyString',"");
            },
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => array('true' => 'true', 'false' => 'false')
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
        $datagrid->add('solarType', 'doctrine_orm_callback', array(
            'label' => 'Solar Type',
            'callback' => array($this, 'handleCheckboxChoiceFilter'),
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getSolarTypeChoices()
            )
        ));            
        $datagrid->add('category', 'doctrine_orm_callback', array(
            'label' => 'Category',
            'callback' => function ($queryBuilder, $alias, $field, $values) {
                if(!$values['value'])
                {
                    return;
                }

                $queryBuilder->andWhere($alias.'.category LIKE :category');
                $queryBuilder->setParameter('category', '%' . $values['value'] . '%');
            },
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Lead::getCategoryChoices()
            )
        ));
        $datagrid->add('appointmentMade', null, array('label' => 'Appointment Made?'));
        $datagrid->add('userAssignedTo', 'doctrine_orm_callback', array(
            'label' => 'Assigned To',
            'callback' => function($queryBuilder, $alias, $field, $values) {
                if(!$values['value'])
                {
                    return;
                }
                if(!$values['value'] || $values['value'] == "")
                {
                    return;
                }
                $queryBuilder->leftjoin($alias.'.userAssignedTo', 'u');
                $queryBuilder->andWhere('u.id = :userId');
                $queryBuilder->setParameter('userId',$values['value']);
                
                return true;
            },
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => $this->getAssignedToChoices()
            ),
        ));
            
        // leave the dates for last since they are tall
        $datagrid->add('DateOfNextFollowup', 'doctrine_orm_date_range', array('label' => 'Date of Next Follow-up'));
        $datagrid->add('datetimeEntered', 'doctrine_orm_date_range', array('label' => 'Date Entered'));
        $datagrid->add('dateAppSubmitted', 'doctrine_orm_date_range', array('label' => 'Date Application Submitted'));
        $datagrid->add('dateAppApproved', 'doctrine_orm_date_range', array('label' => 'Date Application Approved'));
        $datagrid->add('dateOfAssessment', 'doctrine_orm_date_range', array('label' => 'Date of Assessment'));
        $datagrid->add('dateWorkScopeApproved', 'doctrine_orm_date_range', array('label' => 'Date Work Scope Approved'));
        $datagrid->add('dateOfUpgrade', 'doctrine_orm_date_range', array('label' => 'Date of Upgrade'));
        $datagrid->add('DateOfLead', 'doctrine_orm_date_range', array('label' => 'Date of First Contact'));
        
        $datagrid->add('countyEntity', null, array('label' => 'County'), null, array('expanded' => true, 'multiple' => true));

        
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
        'phone' => true,
        'organization' => true,
        'leadType' => true,
        'Campaign' => true,
        'PathStep' => true,
        'DateOfNextFollowup' => true,
        'datetimeEntered' => true,
        'datetimeLastUpdated' => true,
        'DateOfLead' => true,
        'step2aInterested' => true,
        'step2bSubmitted' => true,
        'step2dCompleted' => true,
        'step3' => true,
        'dateAppSubmitted' => true,
        'dateAppApproved' => true,
        'dateWorkScopeApproved' => true,
        'dateOfUpgrade' => true,
        'dateOfAssessment' => true,
        'category' => true,
        'leadEventTitle' => true,
        'appointmentMade' => true,
    	'CRISStatus' => true,
    	'inCRIS' => true,
        'Zip' => true,
        'City' => true,
        'countyEntity' => true,
        'leadStatus' => true,
        'upgradeStatus' => true,
        'solarUpgradeStatus' => true,        
        'SourceOfLead' => true,
        'outreachOrganization' => true,
        'solarType' => true
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
            ->add('countyEntity', array('label' => 'County', 'type' => 'relation', 'relation_field_name' => 'countyEntity_id', 'relation_repository' => 'GJGNYDataToolBundle:County'))
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
            ->add('needToCall', null, array('label' => 'Need to Contact', 'type' => 'boolean'))                
            ->add('DateOfNextFollowup', array('label' => 'Date of next Follow-up', 'type' => 'date'))
            
            ->add('leadTypeUpgrade', array('label' => 'Lead Type: Energy Upgrade', 'type' => 'boolean'))
            ->add('leadTypeOutreach', array('label' => 'Lead Type: Outreach', 'type' => 'boolean'))
            ->add('leadTypeWorkforce', array('label' => 'Lead Type: Workforce', 'type' => 'boolean'))
            ->add('leadTypeSolar', array('label' => 'Lead Type: Solar', 'type' => 'boolean'))
            ->add('category', array('label' => 'Category', 'type' => 'array'))
            ->add('otherNotes', array('label' => 'Other Notes'))                
            ->add('solarTypePV', array('label' => 'Solar Type: PV'))
            ->add('solarTypeHotWater', array('label' => 'Solar Type: Hot Water'))
                
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
            ->add('campaignChoiceTalkingToNeighbors', array('label' => 'Campaign interest: Give program flyer to neighbor or friends', 'type' => 'boolean'))
            ->add('campaignChoiceFormEnergyTeam', array('label' => 'Campaign interest: forming an energy team', 'type' => 'boolean'))
            ->add('campaignChoiceAppearInVideo', array('label' => 'Campaign interest: appear in a testimonial', 'type' => 'boolean'))
            ->add('campaignChoicePresent', array('label' => 'Campaign interest: setup presentation at workplace or organization', 'type' => 'boolean'))
            ->add('campaignChoiceVolunteer', array('label' => 'Campaign interest: becoming a volunteer', 'type' => 'boolean'))
            ->add('campaignChoiceSteward', array('label' => 'Campaign interest: becoming an energy steward', 'type' => 'boolean'))
            ->add('campaignChoiceEvent', array('label' => 'Campaign interest: presenting at event', 'type' => 'boolean'))
            ->add('campaignChoiceOther', array('label' => 'Campaign interest other'))
    
            ->add('upgradeStatus', array('label' => 'Upgrade Status'))
            ->add('step2eContractor', array('label' => 'Name of contractor'))
            ->add('step3bWorkDone', array('label' => 'What was done?'))
            ->add('CRISStatus', array('label' => 'CRIS Status'))
            ->add('dateAppSubmitted', array('label' => 'Date Application Submitted', 'type' => 'date'))
            ->add('dateAppApproved', array('label' => 'Date Application Approved', 'type' => 'date'))
            ->add('dateContractorSelected', array('label' => 'Date Contractor Selected', 'type' => 'date'))
            ->add('dateOfAssessment', array('label' => 'Date of Assessment', 'type' => 'date'))
            ->add('dateWorkScopeApproved', array('label' => 'Date Work Scope Approved', 'type' => 'date'))
            ->add('dateOfUpgrade', array('label' => 'Date of Upgrade', 'type' => 'date'))
                
            ->add('upgradeStatusNotes', array('label' => 'Notes'))
            ->add('outreachOrganization', array('label' => 'Outreach Organization'))
            ->add('dataCounty', array('label' => 'Outreach County'))
            ->add('solarUpgradeStatus', array('label' => 'Solar Upgrade Status', 'type' => 'array'))
        ;


        $solarUpgradeStatusChoices = Lead::getSolarUpgradeStatusChoices();
        foreach(Lead::$solarDateMappings as $statusArrayKey => $fieldNumber)
        {
            $choice = $solarUpgradeStatusChoices[$statusArrayKey];
            $spreadsheetMapper->add('solarDate'.$fieldNumber, array('label' => 'date '.$choice, 'type' => 'date'));
        }            


    }
    
    protected function configureSummaryFields(SummaryMapper $summaryMapper)
    {
        $summaryMapper
            ->addYField('SourceOfLead', array('label' => 'Source of Lead'))
            ->addYField('Program', array('label' => 'Program Source','type' => 'relation', 'relation_field_name' => 'Program_id', 'relation_repository' => 'GJGNYDataToolBundle:Program'))
            ->addYField('DateOfLead', array('label' => 'Date of First Contact', 'type' => 'date'))
            ->addXField('upgradeStatus', array('label' => 'Upgrade Status'))
            ->addXField('CRISStatus', array('label' => 'CRIS Status'))
            ->addXField('countyEntity', array('label' => 'County', 'type' => 'relation', 'relation_field_name' => 'countyEntity_id', 'relation_repository' => 'GJGNYDataToolBundle:County'))
            ->addXField('Town')
            ->addXField('City')
            ->addXField('Zip')
            ->addYField('countyEntity', array('label' => 'County', 'type' => 'relation', 'relation_field_name' => 'countyEntity_id', 'relation_repository' => 'GJGNYDataToolBundle:County'))
            ->addYField('Town')
            ->addYField('City')
            ->addYField('Zip')
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
                ->add('countyEntity', null, array('label' => 'County'))
                ->add('phone', null, array('label' => 'Phone'))
                ->add('primaryPhoneType', null, array('label' => 'type'))
                ->add('secondaryPhone', null, array('label' => 'Secondary Phone'))
                ->add('secondaryPhoneType', null, array('label' => 'type'))
                ->add('personalEmail', null, array('label' => 'Personal E-mail'))
                ->add('workEmail', null, array('label' => 'Work E-mail'))
            ->end()
            ->with('Lead History')
                ->add('outreachOrganization', null, array('label' => 'Outreach Organization'))
                ->add('SourceOfLead', null, array('label' => 'Source of Lead'))
                ->add('sourceOfLeadDetails', null, array('label' => 'Source of Lead Details'))
                ->add('Program', null, array('label' => 'Program Source'))
                ->add('appointmentMade', null, array('label' => 'Appointment Made'))
                ->add('dateOfNextAppointment', null, array('label' => 'Date of next appointment'))
                ->add('DateOfLead', null, array('label' => 'Date of Lead'))
                ->add('needToCall', null, array('label' => 'Need to Contact'))
                ->add('leadStatus', null, array('label' => 'Lead Status'))
                ->add('DateOfNextFollowup', null, array('label' => 'Date of next followup'))
                ->add('userAssignedTo', null, array('label' => 'Assigned To'))
            ->end()
            ->with('Lead Type')
                ->add('leadTypeUpgrade', null, array('label' => 'Energy Upgrade'))
                ->add('leadTypeOutreach', null, array('label' => 'Outreach'))
                ->add('leadTypeWorkforce', null, array('label' => 'Workforce'))
                ->add('leadTypeSolar', null, array('label' => 'Solar'))
                ->add('category', null, array('label' => 'Category', 'template' => 'GJGNYDataToolBundle:Lead:_showCategory.html.twig'))
                ->add('solarTypePV', null, array('label' => 'Solar: PV'))
                ->add('solarTypeHotWater', null, array('label' => 'Solar: Hot Water'))
            ->end()
            ->with('Enery Upgrade')
                ->add('upgradeStatus', null, array('label' => 'Upgrade Status'))
                ->add('CRISStatus', null, array('label' => 'CRIS Status'))
                ->add('step2eContractor', null, array('label' => 'Name of contractor'))
                ->add('dateAppSubmitted', null, array('label' => 'Date Application Submitted'))
                ->add('dateAppApproved', null, array('label' => 'Date Application Approved'))
                ->add('dateContractorSelected', null, array('label' => 'Date Contractor Selected'))
                ->add('dateOfAssessment', null, array('label' => 'Date of Assessment'))
                ->add('dateWorkScopeApproved', null, array('label' => 'Date Work Scope Approved'))
                ->add('dateOfUpgrade', null, array('label' => 'Date of Upgrade'))
                ->add('step3bWorkDone', null, array('label' => 'Description of work completed'))
                ->add('financeOnBill', null, array('label' => 'Financed with On-bill recovery loan'))
                ->add('financeAHP', null, array('label' => 'Financed with AHP'))
                ->add('financeEnergySmart', null, array('label' => 'Financed with Energy Smart (unsecured) loan'))
                ->add('financeHomeEquity', null, array('label' => 'Financed with home equity loan'))
                ->add('financePersonal', null, array('label' => 'Financed with personal loan'))
                ->add('financePocket', null, array('label' => 'Financed with out of pocket'))
                ->add('upgradeStatusNotes', null, array('label' => 'Notes'))
            ->end()
            ->with('Solar Upgrade')
                ->add('solarUpgradeStatus', null, array('label' => 'Solar Upgrade Status', 'template' => 'GJGNYDataToolBundle:Lead:_show_solar_upgrade_status.html.twig'))
            ->end()
            ->with('Outreach')
                ->add('CommunityGroupsConnectedTo', null, array('label' => 'Community groups connected to'))
                ->add('campaignChoiceTalkingToNeighbors', null, array('label' => 'Campaign Interest: Give program flyer to neighbor or friends'))
                ->add('campaignChoiceFormEnergyTeam', null, array('label' => 'Campaign Interest: forming an energy team'))
                ->add('campaignChoiceAppearInVideo', null, array('label' => 'Campaign Interest: appear in a testimonial'))
                ->add('campaignChoicePresent', null, array('label' => 'Campaign Interest: setup presentation at workplace or organization'))
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
               
        $solarUpgradeStatusChoices = Lead::getSolarUpgradeStatusChoices();
        foreach(Lead::$solarDateMappings as $statusArrayKey => $fieldNumber)
        {
            $choice = $solarUpgradeStatusChoices[$statusArrayKey];
            $showMapper->with('Solar Upgrade')->add('solarDate'.$fieldNumber, null, array('label' => 'date '.$choice))->end();
        }            


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
        'step3',
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
    );
    
    public function prePersist($Lead)
    {
        $Lead->setDatetimeEntered(new \DateTime());
        $Lead->setDatetimeLastUpdated(new \DateTime());
        
        if( $this->configurationPool->getContainer()->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
            if(!$Lead->getEnteredBy()) $Lead->setEnteredBy($user); // could be set in form
            if(!$Lead->getLastUpdatedBy()) $Lead->setLastUpdatedBy($user);        
            if(!$Lead->getDataCounty()) $Lead->setDataCounty($user->getCounty()); // could be set in spreadsheet import
        }
            
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
    public function getAssignedToChoices()
    {
        $assignedToChoices = array();
        $em = $this->configurationPool->getContainer()->get('doctrine')->getEntityManager();
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();

        $userQuery = $em->createQuery(
            'SELECT u.firstName, u.lastName, u.id FROM ApplicationSonataUserBundle:User u WHERE u.county=:county ORDER BY u.firstName ASC'
        )->setParameter('county', $user->getCounty());
        
        $users = $userQuery->getResult();
                
        foreach($users as $u)
        {
            if(isset($u['firstName']) && trim($u['firstName']) != "") {
                $assignedToChoices[$u['id']] = $u['firstName'].' '.$u['lastName'];                
            }
        }
       
        return $assignedToChoices;
    }
}
