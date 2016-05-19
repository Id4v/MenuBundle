<?php

namespace Id4v\Bundle\MenuBundle\Builder;

class BaseMenuBuilder implements MenuBuilderInterface
{
    public function buildMenu($node, $items)
    {
        foreach ($items as $item) {
            $elem = $node->addChild($item->getTitle(), array(
                'uri' => $item->getUrl(),
                'linkAttributes' => array(
                    'target' => $item->getTarget(),
                ), )
            );

            if (!$item->isActive()) {
                $elem->setDisplay(false);
                $elem->setDisplayChildren(false);
            }

            if ($item->hasChildren()) {
                $this->buildMenu($node[$item->getTitle()], $item->getChildren());
            }
        }

        return $node;
    }
}
