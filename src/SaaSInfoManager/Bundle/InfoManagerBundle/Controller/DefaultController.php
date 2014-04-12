<?php

namespace SaaSInfoManager\Bundle\InfoManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \SaaSInfoManager\Bundle\InfoManagerBundle\Entity\Client;
use SaaSInfoManager\Bundle\CoreBundle\Entity\TemplateMessage;
use \SaaSInfoManager\Bundle\InfoManagerBundle\Form\ClientType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\HttpFoundation\Request;
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

        $clientForm = $this->createClientForm();
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
        return new Response($this->serialize($client));
    }

    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function saveClientAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $entityId = $request->get('entityId');

        $client = empty($entityId) ? new Client() : $em->getRepository('SaaSInfoManagerInfoManagerBundle:Client')->find($entityId);

        $clientForm = $this->createClientForm($client);
        $clientForm->handleRequest($request);

        if ($clientForm->isValid()) {

            $country = $em->getRepository('SaaSInfoManagerCoreBundle:Country')->find($client->getCountryCode());
            $client->setCountry($country);

            $em->persist($client);
            $em->flush();

            $message = new TemplateMessage('success', 'Client details saved');
        } else {
            $message = new TemplateMessage('error', 'Failed to save client');
        }

        return new Response($this->serialize($message));
    }

    /**
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewCommodityListAction() {
        return $this->render('SaaSInfoManagerInfoManagerBundle:Default:commodity_list.html.twig', array());
    }

    /**
     * 
     * @param \SaaSInfoManager\Bundle\InfoManagerBundle\Entity\Client $entity
     * @return \Symfony\Component\Form\Form
     */
    protected function createClientForm(Client $entity = null) {
        $entity = ($entity instanceof Client) ? $entity : new Client();
        $clientForm = $this->createForm(new ClientType(), $entity, array(
            'action' => $this->generateUrl('saas_info_manager_save_client'),
            'method' => 'POST',
            'attr' => array(
                'id' => 'saas_im_client_form',
            ),
        ));
        $clientForm->add('submit', 'submit', array('label' => 'Save'));

        return $clientForm;
    }

    /**
     * @todo Move this to a service
     * @param type $content
     */
    protected function serialize($content) {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        return $serializer->serialize($content, 'json');
    }

}
