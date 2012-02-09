<?php

/*
 * This file is part of the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace GJGNY\DataToolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PortalController extends Controller
{

    public function portalAction($url)
    {        
        $portalRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:Portal');
        $portal = $portalRepository->findOneByUrl($url);
        
        $portalPartnerLogoRepository = $this->getDoctrine()->getRepository('GJGNYDataToolBundle:PortalPartnerLogo');
        $partnerLogos = $portalPartnerLogoRepository->findBy(array('portal' => $portal->getId()), array('rank' => 'DESC'));
        
        return $this->render('GJGNYDataToolBundle:Portal:portal.html.twig', array(
            'portal' => $portal,
            'partnerLogos' => $partnerLogos
        ));        
    }

}
