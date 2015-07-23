<?php

namespace Id4v\Bundle\MenuBundle\Manager;

use Symfony\Component\Form\FormFactoryInterface;
use Id4v\Bundle\MenuBundle\Form\Type\MenuItemOrderingType;

class MenuManager
{
    protected static $drawForms = 20;

    protected $formFactory;

    /**
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function generateForms($items)
    {
        $forms = array();

        $this->processDepth($forms, $items);

        return $forms;
    }

    public function drawNodeForm(&$forms, $items)
    {
        foreach ($items as $item) {
            $form = $this->formFactory->create(new MenuItemOrderingType(), $item);
            $forms[] = $form->createView();
        }
    }

    public function processDepth(&$forms, $items)
    {
        $this->drawNodeForm($forms, $items);

//        if (count($forms) < $this::$drawForms) {
//            foreach ($items as $item) {
//                $this->processDepth($forms, $item->getChildren());
//            }
//        }
    }
}
