<?php

namespace Id4v\Bundle\MenuBundle\Manager;

use Symfony\Component\Form\FormFactoryInterface;
use Id4v\Bundle\MenuBundle\Form\Type\MenuItemOrderingType;

class MenuManager
{
    protected static $depthMax = 2;

    protected $depthInitial;

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

        if (count($items) < 1)
            return $forms;

        $this->depthInitial = $items[0]->getDepth();
        $this->processDepth($forms, $items);

        return $forms;
    }

    public function drawNodeForm(&$forms, $item)
    {
        $form = $this->formFactory->create(new MenuItemOrderingType(), $item);
        $forms[] = $form->createView();
    }

    public function processDepth(&$forms, $items)
    {
        foreach ($items as $item) {
            $this->drawNodeForm($forms, $item);

            if ($item->getDepth()+1 < $this->depthInitial+$this::$depthMax) {
                $this->processDepth($forms, $item->getChildren());
            }
        }
    }
}
