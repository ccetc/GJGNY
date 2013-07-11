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
use GJGNY\DataToolBundle\Entity\Program as Program;
use GJGNY\DataToolBundle\Admin\LeadEventAdmin as LeadEventAdmin;

class ProgramAdmin extends Admin
{

    protected $maxPerPage = 20;
    protected $classnameLabel = 'Programs';
    protected $entityLabel = 'Program';
    protected $entityLabelPlural = 'Programs';
    protected $entityIconPath = 'bundles/sonataadmin/famfamfam/date.png';

    // Form ======================================================================
    // ===========================================================================
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('name', null, array('label' => 'Event Name'))
                ->add('date', null, array('label' => 'Event Date', 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                ->add('type', 'choice', array('required' => false, 'label' => 'Event Type', 'choices' => Program::getTypeChoices()))
                ->add('typeOther', null, array('label' => 'other'))
                ->add('organization', null, array('label' => 'Event Organization'))
                ->add('email', null, array('label' => 'Event Email'))
                ->add('phone', null, array('label' => 'Event Phone'))
                ->add('address', null, array('label' => 'Event Address'))
                ->add('city', null, array('label' => 'Event City'))
                ->add('zip', null, array('label' => 'Event Zip'))
                ->add('staff', null, array('label' => 'Event Staff'))
                ->add('prepTime', null, array('label' => 'Preparation Time'))
                ->add('eventTime', null, array('label' => 'Event Time'))
                ->add('totalAttendance', null, array('label' => 'Total Attendance (#)'))
                ->add('totalLeads', null, array('label' => 'Total Leads (#)'))
                ->add('totalAppliedAtEvent', null, array('label' => 'Applied at Event (#)'))
                ->add('totalScheduledAppointment', null, array('label' => 'Scheduled Appointment (#)'))
                ->add('hadPersonalConversationWith', null, array('label' => 'Had personal conversation with'))
                ->add('notes', null, array('label' => 'Event Notes'))
                ->setHelps(array(
                    'totalLeads' => 'they gave us their contact information',
                    'notes' => 'audience attributes, degree of engagement with presentation, effect of venue on event, etc'
                ))
      ;
    }
   
    // List ======================================================================
    // ===========================================================================
    public $listPreHook = array('template' => 'GJGNYDataToolBundle:Program:_listPreHook.html.twig');

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('name', 'string', array('label' => 'Name'))
                ->add('type', null, array('label' => 'Event Type', 'template' => 'GJGNYDataToolBundle:Program:_typeList.html.twig'))
                ->add('date', null, array('label' => 'Date'))
                
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
    
    public $formFieldPreHooks = array(
        'typeOther' => 'SonataAdminBundle:Hook:_otherFormFieldPre.html.twig',
    );
    
    public $formFieldPostHooks = array(
        'typeOther' => 'SonataAdminBundle:Hook:_closingDiv.html.twig',
    );
        
    protected function configureSpreadsheetFields(SpreadsheetMapper $spreadsheetMapper)
    {
        $spreadsheetMapper
                ->add('name', array('label' => 'Event Name'))
                ->add('date', array('label' => 'Event Date', 'type' => 'date'))
                ->add('type', array('label' => 'Event Type'))
                ->add('typeOther', array('label' => 'Event Type Other'))
                ->add('organization', array('label' => 'Event Organization'))
                ->add('email', array('label' => 'Event Email'))
                ->add('phone', array('label' => 'Event Phone'))
                ->add('address', array('label' => 'Event Address'))
                ->add('city', array('label' => 'Event City'))
                ->add('zip', array('label' => 'Event Zip'))
                ->add('staff', array('label' => 'Event Staff'))
                ->add('prepTime', array('label' => 'Name'))
                ->add('eventTime', array('label' => 'Name'))
                ->add('totalAttendance', array('label' => 'Total Attendance (#)'))
                ->add('totalLeads', array('label' => 'Total Leads (#)'))
                ->add('totalAppliedAtEvent', array('label' => 'Applied at Event (#)'))
                ->add('totalScheduledAppointment', array('label' => 'Scheduled Appointment (#)'))
                ->add('hadPersonalConversationWith', array('label' => 'Had personal conversation with'))
                ->add('notes', array('label' => 'Event Notes'))
            ;
    }
    
    protected function configureSummaryFields(SummaryMapper $summaryMapper)
    {
        $summaryMapper
            ->addXField('name', array('label' => 'Event Name'))
            ->addXField('type', array('label' => 'Event Type'))
            ->addXField('totalAttendance', array('label' => 'Total Attendance (#)'))
            ->addXField('totalLeads', array('label' => 'Total Leads (#)'))
            ->addXField('totalAppliedAtEvent', array('label' => 'Applied at Event (#)'))
            ->addXField('totalScheduledAppointment', array('label' => 'Scheduled Appointment (#)'))
            ->addYField('totalAttendance', array('label' => 'Total Attendance (#)'))
            ->addYField('type', array('label' => 'Event Type'))
            ->addYField('name', array('label' => 'Event Name'))
            ->addYField('totalLeads', array('label' => 'Total Leads (#)'))
            ->addYField('totalAppliedAtEvent', array('label' => 'Applied at Event (#)'))
            ->addYField('totalScheduledAppointment', array('label' => 'Scheduled Appointment (#)'))
        ;
    }
                
    protected function configureDatagridFilters(DatagridMapper $datagrid)
    {
        $datagrid->add('name', null, array('label' => 'Name'));
        $datagrid->add('dataCounty', 'doctrine_orm_choice', array(
            'label' => 'Outreach County',
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => array('Broome' => 'Broome', 'Tompkins' => 'Tompkins')
            )
        ));
        $datagrid->add('type', 'doctrine_orm_choice', array(
            'label' => 'Event Type',
            'field_type' => 'choice',
            'field_options' => array(
                'required' => false,
                'choices' => Program::getTypeChoices()
            )
        ));
        $datagrid
            ->add('email', null, array('label' => 'Event Email'))
            ->add('phone', null, array('label' => 'Event Phone'))
            ->add('totalAttendance', null, array('label' => 'Total Attendance (#)'))
            ->add('totalLeads', null, array('label' => 'Total Leads (#)'))
            ->add('totalAppliedAtEvent', null, array('label' => 'Applied at Event (#)'))
            ->add('totalScheduledAppointment', null, array('label' => 'Scheduled Appointment (#)'))
        ;
        $datagrid->add('date', 'doctrine_orm_date_range', array('label' => 'Date'));

        $this->initializeDefaultFilters();
    }

    public $hiddenFilters = array(
        'email' => true,
        'phone' => true,
        'totalAttendance' => true,
        'totalLeads' => true,
        'totalAppliedAtEvent' => true,
        'totalScheduledAppointment' => true,
        'date' => true,
    );
    
    public function initializeDefaultFilters()
    {
       $this->filterDefaults['dataCounty'] = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser()->getCounty();
    }

    // Show ======================================================================
    // ===========================================================================
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('name', null, array('label' => 'Event Name'))
                ->add('date', null, array('label' => 'Event Date', 'widget' => 'single_text', 'format' => 'MM/dd/yyyy', 'attr' => array('class' => 'datepicker')))
                ->add('type', null, array('label' => 'Event Type', 'template' => 'GJGNYDataToolBundle:Program:_typeShow.html.twig'))
                ->add('organization', null, array('label' => 'Event Organization'))
                ->add('email', null, array('label' => 'Event Email'))
                ->add('phone', null, array('label' => 'Event Phone'))
                ->add('address', null, array('label' => 'Event Address'))
                ->add('city', null, array('label' => 'Event City'))
                ->add('zip', null, array('label' => 'Event Zip'))
                ->add('staff', null, array('label' => 'Event Staff'))
                ->add('prepTime', null, array('label' => 'Name'))
                ->add('eventTime', null, array('label' => 'Name'))
                ->add('totalAttendance', null, array('label' => 'Total Attendance (#)'))
                ->add('totalLeads', null, array('label' => 'Total Leads (#)'))
                ->add('totalAppliedAtEvent', null, array('label' => 'Applied at Event (#)'))
                ->add('totalScheduledAppointment', null, array('label' => 'Scheduled Appointment (#)'))
                ->add('hadPersonalConversationWith', null, array('label' => 'Had personal conversation with'))
                ->add('notes', null, array('label' => 'Event Notes'))
        ;
        
        $this->initializeShowHooks();
    }
        
    public $showPreHook = array(
        'template' => 'GJGNYDataToolBundle:Program:_showPreHook.html.twig',
    );
       
    public function initializeShowHooks()
    {
        $this->showPreHook['parameters'] = array(
            'LeadAdmin' =>  $this->configurationPool->getContainer()->get('gjgny.datatool.admin.lead')
        );
    }
    
    
    public function prePersist($Program)
    {
        $Program->setDatetimeEntered(new \DateTime());
        $Program->setDatetimeLastUpdated(new \DateTime());
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
        $Program->setEnteredBy($user);
        $Program->setLastUpdatedBy($user);
        $Program->setDataCounty($user->getCounty());

        parent::prePersist($Program);
    }

    public function preUpdate($Program)
    {
        $Program->setDatetimeLastUpdated(new \DateTime());
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser();
        $Program->setLastUpdatedBy($user);

        parent::preUpdate($Program);
    }

}
