<?php

namespace SaaSInfoManager\Bundle\InfoManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClientDeactivationType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('id', 'hidden', array(
                    'constraints' => array(
                        new NotBlank(),
                    ),
                ))
                ->add('submit', 'submit')
        ;
    }

    /**
     * @return string
     */
    public function getName() {
        return 'saas_im_client_deactivation_form';
    }

}
