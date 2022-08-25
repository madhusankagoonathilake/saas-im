<?php

namespace SaaSInfoManager\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SaaSInfoManagerCoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
