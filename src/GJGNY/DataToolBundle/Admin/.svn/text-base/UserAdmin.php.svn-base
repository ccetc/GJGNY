<?php

namespace GJGNY\DataToolBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use GJGNY\DataToolBundle\Entity\User as User;
use GJGNY\AdminExtensionBundle\Admin\CustomAdmin;
use FOS\UserBundle\Model\UserManagerInterface;

class UserAdmin extends CustomAdmin
{

    protected $maxPerPage = 10;
    protected $classnameLabel = 'Users';
    protected $classSingular = 'User';
    public $classname = 'User';
    protected $entityDescription = 'Users must be "approved" by an Admin before they can log in.  Admins are able to approve other users as well promote users to also be Admins.';

    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('approve', 'approve/{user_id}');
        $collection->add('unapprove', 'unapprove/{user_id}');
        $collection->add('promote', 'promote/{user_id}');
        $collection->add('demote', 'demote/{user_id}');
    }

    // Form ======================================================================
    // ===========================================================================
    public function configureFormFields(FormMapper $form)
    {
        $form->add('firstName', array('label' => 'First Name', 'required' => false));
        $form->add('lastName', array('label' => 'Last Name', 'required' => false));
        $form->add('organization', array('label' => 'Organization', 'required' => false));
        $form->add('county', array('label' => 'County', 'required' => false, 'choices' => array("Broome" => "Broome", "Tompkins" => "Tompkins")), array('type' => 'choice'));
        $form->add('email', array('label' => 'E-mail', 'required' => false));
        $form->add('plainPassword', array('label' => 'Password', 'required' => false), array('type' => 'string'));
        $form->add('enabled', array('label' => 'Approved', 'required' => false));
    }

    public function prePersist($user)
    {
        $this->getUserManager()->updatePassword($user);
        $this->getUserManager()->updateCanonicalFields($user);
    }

    public function preUpdate($user)
    {
        $this->getUserManager()->updatePassword($user);
        $this->getUserManager()->updateCanonicalFields($user);
    }

    public function getUserManager()
    {
        return $this->configurationPool->getContainer()->get('fos_user.user_manager');
    }

    // List ======================================================================
    // ===========================================================================
    protected $list = array(
        'lastName' => array('name' => 'Name', 'template' => 'GJGNYDataToolBundle:User:_name.html.twig'),
        'email' => array('name' => 'E-mail'),
        'organization' => array('name' => 'Organization'),
        'county' => array('name' => 'County'),
        'enabled' => array('name' => 'Approved'),
        'isAdmin' => array('name' => 'Admin', 'type' => 'string', 'template' => 'GJGNYDataToolBundle:User:_isAdmin.html.twig'),
        'createdAt' => array('name' => 'Date Created'),
        '_action' => array(
            'actions' => array(
                'approve' => array('template' => 'GJGNYDataToolBundle:User:_approveAction.html.twig'),
                'unapprove' => array('template' => 'GJGNYDataToolBundle:User:_unapproveAction.html.twig'),
                'promote' => array('template' => 'GJGNYDataToolBundle:User:_promoteAction.html.twig'),
                'demote' => array('template' => 'GJGNYDataToolBundle:User:_demoteAction.html.twig'),
                'delete' => array()
            )
        )
    );

    public function getBatchActions()
    {
        return array(
            'Approve' => 'Approve Selected',
            'Unapprove' => 'Unapprove Selected',
            'AddAdmin' => 'Promote Selected to Admin',
            'RemoveAdmin' => 'Demote Selected from Admin',
        );
    }

    public function configureDatagridFilters(DatagridMapper $datagrid)
    {
        $datagrid->add('enabled', array('name' => 'Approved'));
        $datagrid->add('organization', array('name' => 'Organization'));
        $datagrid->add('email', array('name' => 'E-mail'));
        $datagrid->add('isAdmin', array(
            'name' => 'Is Admin',
            'template' => 'SonataAdminBundle:CRUD:filter_boolean.html.twig',
            'type' => 'callback',
            'filter_options' => array(
                'filter' => array($this, 'handleIsAdminFilter'),
                'type' => 'choice',
            ),
            'filter_field_options' => array(
                'required' => true,
                'choices' => array('all' => 'all', 'true' => 'true', 'false' => 'false')
            )
        ));
        $datagrid->add('Name', array(
            'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
            'type' => 'callback',
            'filter_options' => array(
                'filter' => array($this, 'handleNameFilter'),
            ),
            'filter_field_options' => array(
                'required' => false,
            ),
        ));
        $datagrid->add('county', array(
            'name' => 'County',
            'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
            'type' => 'callback',
            'filter_options' => array(
                'filter' => array($this, 'handleCountyFilter'),
                'type' => 'choice'
            ),
            'filter_field_options' => array(
                'required' => false,
                'choices' => array('Broome' => 'Broome', 'Tompkins' => 'Tompkins')
            )
        ));
        $this->initializeDefaultFilters();
    }

    public function initializeDefaultFilters()
    {
        $this->filterDefaults['county'] = $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser()->getCounty();
    }

    public function handleCountyFilter($queryBuilder, $alias, $field, $value)
    {
        if(!$value)
        {
            return;
        }

        $queryBuilder->andWhere($alias . '.county = :county');
        $queryBuilder->setParameter('county', $value);
    }

    public function handleNameFilter($queryBuilder, $alias, $field, $value)
    {
        if(!$value)
        {
            return;
        }

// doctine QB does not support three params in CONCAT, so ignore the space
        $value = str_replace(" ", "", $value);

        $queryBuilder->andWhere(sprintf('%s.firstName LIKE :value OR %s.lastName LIKE :value
            OR (CONCAT(%s.firstName, %s.lastName)) = :fullName', $alias, $alias, $alias, $alias));
        $queryBuilder->setParameter('value', '%' . $value . '%');
        $queryBuilder->setParameter('fullName', $value);
    }

    public function handleIsAdminFilter($queryBuilder, $alias, $field, $value)
    {
        if(!$value)
        {
            return;
        }

        if($value == 'true')
        {
            $queryBuilder->andWhere($alias . ".roles LIKE '%ROLE_ADMIN%'");
        }
        else if($value == 'false')
        {
            $queryBuilder->andWhere($alias . ".roles NOT LIKE '%ROLE_ADMIN%'");
        }
    }

    // View ======================================================================
    // ===========================================================================
}
