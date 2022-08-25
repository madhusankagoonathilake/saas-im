<?php

namespace SaaSInfoManager\Bundle\AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('SaaSInfoManagerAuthBundle:Default:index.html.twig');
    }

}
