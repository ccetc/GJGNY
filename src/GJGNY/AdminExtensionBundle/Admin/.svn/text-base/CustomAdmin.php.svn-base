<?php

namespace GJGNY\AdminExtensionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\ValidatorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Model\DomainObjectInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Admin\Pool;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Builder\FormContractorInterface;
use Sonata\AdminBundle\Builder\ListBuilderInterface;
use Sonata\AdminBundle\Builder\DatagridBuilderInterface;
use Sonata\AdminBundle\Builder\ViewBuilderInterface;
use Sonata\AdminBundle\Security\Handler\SecurityHandlerInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use Knplabs\Bundle\MenuBundle\Menu;
use Knplabs\Bundle\MenuBundle\MenuItem;

abstract class CustomAdmin extends Admin implements AdminInterface, DomainObjectInterface
{

  /**
   * Generates the breadcrumbs array
   *
   * @param string $action
   * @param \Knplabs\MenuBundle\MenuItem|null $menu
   * @return array the breadcrumbs
   */
  public function buildBreadcrumbs($action, MenuItem $menu = null)
  {
    if(isset($this->breadcrumbs[$action]))
    {
      return $this->breadcrumbs[$action];
    }

    $menu = $menu ? : new Menu;

    $child = $menu->addChild(
                    $this->getClassnameLabel(), $this->generateUrl('list')
    );

    $childAdmin = $this->getCurrentChildAdmin();

    if($childAdmin)
    {
      $id = $this->request->get($this->getIdParameter());

      $child = $child->addChild(
                      (string) $this->getSubject(), $this->generateUrl('edit', array('id' => $id))
      );

      return $childAdmin->buildBreadcrumbs($action, $child);
    }
    elseif($this->isChild())
    {

      if($action != 'list')
      {
        $menu = $menu->addChild(
                        $this->$this->getClassnameLabel(), $this->generateUrl('list')
        );
      }

      $breadcrumbs = $menu->getBreadcrumbsArray(
                      $this->$action
      );
    }
    else if($action != 'list')
    {

      $breadcrumbs = $child->getBreadcrumbsArray(
                      $action
      );
    }
    else
    {

      $breadcrumbs = $child->getBreadcrumbsArray();
    }

    // the generated $breadcrumbs contains an empty element
    array_shift($breadcrumbs);

    return $this->breadcrumbs[$action] = $breadcrumbs;
  }

  /**
   * Returns the list template
   *
   * @return string the list template
   */
  public function getListTemplate()
  {
    return 'GJGNYAdminExtensionBundle:CRUD:list.html.twig';
  }

  /**
   * Returns the edit template
   *
   * @return string the edit template
   */
  public function getEditTemplate()
  {
    return 'GJGNYAdminExtensionBundle:CRUD:edit.html.twig';
  }

  /**
   * Returns the view template
   *
   * @return string the view template
   */
  public function getViewTemplate()
  {
    return 'GJGNYAdminExtensionBundle:CRUD:view.html.twig';
  }

  /**
   * A short description of the entity
   * @var string
   */
  protected $entityDescription;
  /**
   * Values in this array are displayed preceding the form element that matches the key
   * @var associative array
   */
  protected $formLabels;
  /**
   * The singular noun used to describe the class (likely the table name)
   * @var string
   */
  protected $classSingular = 'Item';
  /**
   * The plural noun used to describe the class.
   * If not defined, an s is added to classSingular
   * @var type 
   */
  protected $classPlural;
  public $hiddenFilters = array();
  public $classname;
  protected $viewChoiceGroups;
  
  public function getEntityDescription()
  {
    return $this->entityDescription;
  }

  public function getFormLabels()
  {
    return $this->formLabels;
  }

  public function getClassSingular()
  {
    return $this->classSingular;
  }

  public function getClassPlural()
  {
    if(!isset($this->classPlural))
      return $this->getClassSingular() . 's';
    else
      return $this->classPlural;
  }

  public function getViewFieldDescriptions()
  {
    $this->buildViewFieldDescriptions();

    return $this->viewFieldDescriptions;
  }
  
  public $filterDefaults = array();

}

