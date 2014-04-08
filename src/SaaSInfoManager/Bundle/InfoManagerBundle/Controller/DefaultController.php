<?php

namespace SaaSInfoManager\Bundle\InfoManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \SaaSInfoManager\Bundle\InfoManagerBundle\Entity\Client;
use \SaaSInfoManager\Bundle\InfoManagerBundle\Form\ClientType;

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
//        $service = $this->get('saas_info_manager.client_service');
//        $clientList = $service->getClientList();
        $em = $this->getDoctrine()->getManager();

        $clientForm = $this->createForm(new ClientType(), new Client(), array(
            'action' => $this->generateUrl('client_create'),
            'method' => 'POST',
        ));
        $clientForm->add('submit', 'submit', array('label' => 'Save'));
        
        $clientList = $em->getRepository('SaaSInfoManagerInfoManagerBundle:Client')->findAll();

        return $this->render('SaaSInfoManagerInfoManagerBundle:Default:client_list.html.twig', array(
                    'clientList' => $clientList,
                    'clientForm' => $clientForm->createView(),
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
