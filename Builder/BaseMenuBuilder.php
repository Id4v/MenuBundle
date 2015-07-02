<?php

namespace Id4v\Bundle\MenuBundle\Builder;

use Knp\Menu\FactoryInterface;
use Doctrine\ORM\EntityManager;

class BaseMenuBuilder {

    protected $factory;

    protected $em;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, EntityManager $em)
    {
        $this->factory = $factory;
        $this->em = $em;
    }

    protected function generateMenu(&$node, $items)
    {
        foreach ($items as $item)
        {
            $elem = $node->addChild($item->getTitle(), array(
                'uri' => $item->getUrl(),
                'linkAttributes' => array(
                    'target' => $item->getTarget(),
                ))
            );

            if (!$item->isActive()) {
                $elem->setDisplay(false);
                $elem->setDisplayChildren(false);
            }

            if ($item->hasChildren()) {
                $this->generateMenu($node[$item->getTitle()], $item->getChildren());
            }
        }
    }

    protected function getSimpleMenu($slug)
    {
        $menu = $this->factory->createItem('root');

        $rootNodes = $this->getMenuNodes($slug);

        if (empty($rootNodes)) {
            return $menu;
        }

        $this->generateMenu($menu, $rootNodes);

        return $menu;
    }

    protected function getMenuNodes($slug)
    {
        return $this->getMenuRepository()->getRootNodesBySlug($slug);
    }

    protected function getMenuRepository()
    {
        return $this->em->getRepository('Id4vMenuBundle:MenuItem');
    }
}