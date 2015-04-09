<?php

namespace Id4v\Bundle\MenuBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MenuItemAdmin extends Admin
{
    protected $parentAssociationMapping = 'menu';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('title')
            ->add('url')
            ->add('active')
            ->add('target')
            ->add('position')
            ->add('depth')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('title')
            ->add('url')
            ->add('active')
            ->add('target')
            ->add('position')
            ->add('depth')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', null, array(
                'label' => 'Titre',
            ))
            ->add('url', null, array(
                'label' => 'Lien',
            ))
            ->add('active', null, array(
                'label' => 'Activé',
                'required' => false,
            ))
            ->add('target', 'choice', array(
                'label' => 'Ouverture',
                'choices' => array(
                    '_self' => 'Même fenetre',
                    '_target' => 'Nouvelle fenêtre',
                ),
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('url')
            ->add('active')
            ->add('target')
            ->add('position')
            ->add('depth')
        ;
    }
}
