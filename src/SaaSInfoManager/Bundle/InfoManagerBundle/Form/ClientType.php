<?php

namespace SaaSInfoManager\Bundle\InfoManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use SaaSInfoManager\Bundle\InfoManagerBundle\Entity\ClientRepository;

class ClientType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text', array(
                    'constraints' => array(
                        new Length(array('min' => 3, 'max' => 100)),
                        new NotBlank(),
                    ),
                ))
                ->add('email', 'email')
                ->add('contactNumber')
                ->add('address1')
                ->add('address2')
                ->add('city')
                ->add('countryCode', 'country', array(
                    'empty_value' => '---'
                ))
                ->add('status', 'hidden', array(
                    'data' => ClientRepository::ACTIVE
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'SaaSInfoManager\Bundle\InfoManagerBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'saas_im_client_form';
    }

}
