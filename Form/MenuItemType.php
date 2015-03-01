<?php

namespace Overscan\Bundle\MenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('url')
            ->add('active',null,array("required"=>false))
            ->add('target')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Overscan\Bundle\MenuBundle\Entity\MenuItem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'overscan_bundle_menubundle_menuitem';
    }
}
