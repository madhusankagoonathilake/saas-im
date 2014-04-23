<?php

namespace SaaSInfoManager\Bundle\InfoManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SaaSInfoManager\Bundle\InfoManagerBundle\Entity\Client;
use SaaSInfoManager\Bundle\InfoManagerBundle\Entity\ClientRepository;
use SaaSInfoManager\Bundle\CoreBundle\Entity\TemplateMessage;
use SaaSInfoManager\Bundle\InfoManagerBundle\Form\ClientType;
use SaaSInfoManager\Bundle\InfoManagerBundle\Form\ClientDeactivationType;
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
    public function viewClientListAction() {
        $em = $this->getDoctrine()->getManager();

        $clientForm = $this->createClientForm();
        $clientDeactivationForm = $this->createClientDeactivationForm();
        $clientList = $em->getRepository('SaaSInfoManagerInfoManagerBundle:Client')->findBy(array(
            'status' => ClientRepository::ACTIVE,
        ), array(
            'name' => 'ASC',
        ));

        return $this->render('SaaSInfoManagerInfoManagerBundle:Default:client_list.html.twig', array(
                    'clientList' => $clientList,
                    'clientForm' => $clientForm->createView(),
                    'clientDeactivationForm' => $clientDeactivationForm->createView(),
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
            $message = new TemplateMessage('failure', 'Failed to save client');
        }

        return new Response($this->serialize($message));
    }

    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deactivateClientAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $entityId = $request->get('entityId');

        $clientDeactivationForm = $this->createClientDeactivationForm();
        $clientDeactivationForm->handleRequest($request);

        if (!empty($entityId) && $clientDeactivationForm->isValid()) {
            $client = $em->getRepository('SaaSInfoManagerInfoManagerBundle:Client')->find($entityId);

            $client->setStatus(ClientRepository::INACTIVE);

            $em->persist($client);
            $em->flush();

            $message = new TemplateMessage('success', 'Client deactivated');
        } else {
            $message = new TemplateMessage('failure', 'Failed to deactivate client');
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
     * 
     * @return \Symfony\Component\Form\Form
     */
    protected function createClientDeactivationForm() {
        $clientDeactivationForm = $this->createForm(new ClientDeactivationType(), null, array(
            'action' => $this->generateUrl('saas_info_manager_deactivate_client'),
            'method' => 'POST',
            'attr' => array(
                'id' => 'saas_im_client_deactivation_form',
            ),
        ));
        
        return $clientDeactivationForm;
    }

    /**
     * @todo Move this to a service
     * @param type $content
     */
    protected function serialize($content) {
        $serializer = $this->get('jms_serializer');
        return $serializer->serialize($content, 'json');
    }

}
