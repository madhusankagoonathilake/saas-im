<?php

namespace SaaSInfoManager\Bundle\InfoManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use SaaSInfoManager\Bundle\InfoManagerBundle\Entity\ClientRepository;

class ClientContactsType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('firstName', 'text', array(
                    'constraints' => array(
                        new Length(array('min' => 3, 'max' => 100)),
                        new NotBlank(),
                    ),
                ))
                ->add('lastName', 'text', array(
                    'constraints' => array(
                        new Length(array('min' => 3, 'max' => 100)),
                        new NotBlank(),
                    ),
                ))
                ->add('jobTitle', 'text')
                ->add('email', 'email')
                ->add('contactNumber')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'SaaSInfoManager\Bundle\InfoManagerBundle\Entity\ClientContact'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'saas_im_client_contacts_form';
    }

}
