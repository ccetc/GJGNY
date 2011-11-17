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
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

use FOS\UserBundle\Controller\SecurityController as ParentController;

class SecurityController extends ParentController
{
    public function loginAction()
    {
        $ua = $_SERVER['HTTP_USER_AGENT'];
	if((!isset($_SESSION['ie6_message']) || $_SESSION['ie6_message'] == true) && preg_match('/\bmsie 6/i', $ua) && !preg_match('/\bopera/i', $ua)) {
          $usingIE6 = true;
        }
        else{
          $usingIE6 = false;
        }
        
      
        $request = $this->container->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        /* @var $session \Symfony\Component\HttpFoundation\Session */

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }
        
        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
            
            // customize the disable account error message
            if($error == 'User account is disabled.') $error = 'Your account must first be approved by an administrator before you can login.  You can contact your administrator and ask to be approved.';
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Security:login.html.'.$this->container->getParameter('fos_user.template.engine'), array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'usingIE6'  => $usingIE6,
        ));
    }

}
