<?php

namespace SaaSInfoManager\Bundle\InfoManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    /**
     * 
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($name) {
        return $this->render('SaaSInfoManagerInfoManagerBundle:Default:index.html.twig', array('name' => $name));
    }

    /**
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewCompanyListAction() {
        $service = $this->get('saas_info_manager.client_service');
        $clientList = $service->getClientList();
        return $this->render('SaaSInfoManagerInfoManagerBundle:Default:client_list.html.twig', array(
                    'clientList' => $clientList,
        ));
    }

    /**
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewCommodityListAction() {
        return $this->render('SaaSInfoManagerInfoManagerBundle:Default:commodity_list.html.twig', array());
    }

}
