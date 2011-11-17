<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GJGNY\ChildBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Controller\RegistrationController as ParentController;

/**
 * Controller managing the registration
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class RegistrationController extends ParentController
{

  protected function sendApprovalNeededEmail($user)
  {
    $httpHost = $this->container->get('request')->getHttpHost();
    $baseUrl = $this->container->get('request')->getBaseUrl();
    $baseLink = $httpHost . $baseUrl;


    
    $message = \Swift_Message::newInstance()
            ->setSubject('GJGNY Data Tool - Approval needed')
            ->setFrom($this->container->getParameter('fos_user.registration.confirmation.from_email'))
            ->setTo($this->container->get('gjgny')->admins[$user->getCounty()])
            ->setContentType('text/html')
            ->setBody('<html>
                      ' . $user . ' has created an account on the GJGNY Data Tool.<br/>
                      Before this user can use the tool, you must approve their account.<br/>
                      You can view all unapproved users by going to this address:<br/>
                      <a href="http://' . $baseLink . '/admin/gjgny/datatool/user/list?enabled=false">http://' . $baseLink . '/admin/gjgny/datatool/user/list?enabled=false</a>
                      </html>'
            )
    ;
    $this->container->get('mailer')->send($message);
  }

  public function registerAction()
  {
    $form = $this->container->get('fos_user.registration.form');
    $formHandler = $this->container->get('fos_user.registration.form.handler');
    $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

    $httpHost = $this->container->get('request')->getHttpHost();
    $baseUrl = $this->container->get('request')->getBaseUrl();
    $baseLink = $httpHost . $baseUrl;

    $process = $formHandler->process($confirmationEnabled);
    if($process)
    {
      $user = $form->getData();

      if($confirmationEnabled)
      {
        $this->setFlash('adminMessage',
          'Before you can log in an admin must verify your account.  Your admin has been asked to approve your account, but if need be you can contact your admin at ' . $this->container->get('gjgny')->admins[$user->getCounty()] . ' and request to be approved.');
        $route = 'fos_user_security_login';

        $this->sendApprovalNeededEmail($user);
      }
      else
      {
        $this->setFlash('adminMessage', 'Your account has been created.  You are now logged in');
        $this->authenticateUser($user);
        $route = 'home';
      }

      $url = $this->container->get('router')->generate($route);

      return new RedirectResponse($url);
    }

    return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.' . $this->getEngine(), array(
        'registrationForm' => $form->createView(),
        'theme' => $this->container->getParameter('fos_user.template.theme'),
    ));
  }

}