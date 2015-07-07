<?php

namespace Id4v\Bundle\MenuBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuItemOrderingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('id', 'hidden')
          ->add('position', 'integer')
          ->add('depth', 'hidden')
          ->add('parent', null, array('attr' => array('data-sonata-select2' => 'false')))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setConfigureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
          'data_class' => 'Id4v\Bundle\MenuBundle\Entity\MenuItem',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'overscan_bundle_menubundle_menuitem_'.rand();
    }
}
