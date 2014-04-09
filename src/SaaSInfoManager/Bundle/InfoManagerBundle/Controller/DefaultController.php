<?php

namespace SaaSInfoManager\Bundle\InfoManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \SaaSInfoManager\Bundle\InfoManagerBundle\Entity\Client;
use \SaaSInfoManager\Bundle\InfoManagerBundle\Form\ClientType;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\HttpFoundation\Response;

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
     * @param int $id
     */
    public function viewClientAction($id) {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('SaaSInfoManagerInfoManagerBundle:Client')->find($id);
        $encoders = array(new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $reports = $serializer->serialize($client, 'json');
        return new Response($reports);
    }

    /**
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewCommodityListAction() {
        return $this->render('SaaSInfoManagerInfoManagerBundle:Default:commodity_list.html.twig', array());
    }

}
