<?php

namespace GJGNY\DataToolBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use GJGNY\AdminExtensionBundle\Controller\CustomCRUDController as CustomController;
use Sonata\AdminBundle\Datagrid\ORM\ProxyQuery;

class UserAdminController extends CustomController
{

  protected function getPageLink()
  {
    $httpHost = $this->container->get('request')->getHttpHost();
    $baseUrl = $this->container->get('request')->getBaseUrl();
    return 'http://' . $httpHost . $baseUrl;
  }

  public function sendAccountApprovedEmail($toAddress)
  {
    $message = \Swift_Message::newInstance()
            ->setSubject('GJGNY Data Tool Account Approved')
            ->setFrom($this->container->getParameter('fos_user.registration.confirmation.from_email'))
            ->setTo($toAddress)
            ->setContentType('text/html')
            ->setBody('<html>
               Your account on the GJGNY Data Tool has been approved by an admin.<br/>
               You can now log in and use the tool.<br/>
               <a href="' . $this->getPageLink().'">'.$this->getPageLink().'</a></html>')
    ;
    $this->get('mailer')->send($message);
  }

  public function sendAccountPromotedEmail($toAddress)
  {
    $message = \Swift_Message::newInstance()
            ->setSubject('GJGNY Data Tool Promoted to Admin')
            ->setFrom($this->container->getParameter('fos_user.registration.confirmation.from_email'))
            ->setTo($toAddress)
            ->setContentType('text/html')
            ->setBody('<html>
              You have been given administrator access to the GJGNY Data Tool.<br/>
              You can now log in and use the admin tools.<br/>
              <a href="' . $this->getPageLink() . '">'.$this->getPageLink().'</a></html>')
    ;
    $this->get('mailer')->send($message);
  }

  public function batchActionApprove(ProxyQuery $queryProxy)
  {
    $em = $this->getDoctrine()->getEntityManager();

    foreach($queryProxy->getQuery()->iterate() as $pos => $object)
    {
      $object[0]->setEnabled('1');

      $this->sendAccountApprovedEmail($object[0]->getEmail());
    }

    $em->flush();
    $em->clear();

    $this->getRequest()->getSession()->setFlash('adminMessage', 'The selected users have been approved');

    return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
  }

  public function batchActionUnapprove(ProxyQuery $queryProxy)
  {
    $em = $this->getDoctrine()->getEntityManager();

    foreach($queryProxy->getQuery()->iterate() as $pos => $object)
    {
      $object[0]->setEnabled('0');
    }

    $em->flush();
    $em->clear();

    $this->getRequest()->getSession()->setFlash('adminMessage', 'The selected users have been unapproved');

    return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
  }

  public function batchActionAddAdmin(ProxyQuery $queryProxy)
  {
    $em = $this->getDoctrine()->getEntityManager();

    foreach($queryProxy->getQuery()->iterate() as $pos => $object)
    {
      $object[0]->addRole('ROLE_ADMIN');

      $this->sendAccountPromotedEmail($object[0]->getEmail());
    }

    $em->flush();
    $em->clear();

    $this->getRequest()->getSession()->setFlash('adminMessage', 'The selected users have been promoted');

    return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
  }

  public function batchActionRemoveAdmin(ProxyQuery $queryProxy)
  {
    $em = $this->getDoctrine()->getEntityManager();

    foreach($queryProxy->getQuery()->iterate() as $pos => $object)
    {
      $object[0]->removeRole('ROLE_ADMIN');
    }

    $em->flush();
    $em->clear();

    $this->getRequest()->getSession()->setFlash('adminMessage', 'The selected users have been demoted');

    return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
  }

  public function approveAction($user_id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $userManager = $this->container->get('fos_user.user_manager');
    $user = $userManager->findUserBy(array("id" => $user_id));
    $user->setEnabled('1');

    $em->flush();
    $em->clear();

    $this->sendAccountApprovedEmail($user->getEmail());

    $this->getRequest()->getSession()->setFlash('adminMessage', $user->getEmail() . ' has been approved');

    return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
  }

  public function unapproveAction($user_id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $userManager = $this->container->get('fos_user.user_manager');
    $user = $userManager->findUserBy(array("id" => $user_id));
    $user->setEnabled('0');

    $em->flush();
    $em->clear();

    $this->getRequest()->getSession()->setFlash('adminMessage', $user->getEmail() . ' has been unapproved');


    return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
  }

  public function promoteAction($user_id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $userManager = $this->container->get('fos_user.user_manager');
    $user = $userManager->findUserBy(array("id" => $user_id));
    $user->addRole('ROLE_ADMIN');

    $em->flush();
    $em->clear();

    $this->sendAccountPromotedEmail($user->getEmail());

    $this->getRequest()->getSession()->setFlash('adminMessage', $user->getEmail() . ' has been promoted');

    return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
  }

  public function demoteAction($user_id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $userManager = $this->container->get('fos_user.user_manager');
    $user = $userManager->findUserBy(array("id" => $user_id));
    $user->removeRole('ROLE_ADMIN');

    $em->flush();
    $em->clear();

    $this->getRequest()->getSession()->setFlash('adminMessage', $user->getEmail() . ' has been demoted');

    return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
  }

}