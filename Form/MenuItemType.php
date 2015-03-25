<?php

namespace Id4v\Bundle\MenuBundle\Form;

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
            ->add('target',"choice",array(
                "label"=>"Ouverture",
                "choices"=>array(
                    "_self"=>"Meme fenetre",
                    "_target"=>"Nouvelle fenetre"
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Id4v\Bundle\MenuBundle\Entity\MenuItem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'id4v_bundle_menubundle_menuitem';
    }
}
