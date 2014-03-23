<?php

namespace SaaSInfoManager\Bundle\InfoManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('contactNumber')
            ->add('address1')
            ->add('address2')
            ->add('city')
            ->add('countryId')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SaaSInfoManager\Bundle\InfoManagerBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'saasinfomanager_bundle_infomanagerbundle_client';
    }
}
