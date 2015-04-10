<?php

/**
 * Created by PhpStorm.
 * User: david
 * Date: 08/04/15
 * Time: 21:49.
 */

namespace Id4v\Bundle\MenuBundle\Service;

use Id4v\Bundle\MenuBundle\Entity\Menu;
use Id4v\Bundle\MenuBundle\Entity\MenuItem;
use Symfony\Component\HttpFoundation\RequestStack;

class RouteMatcher
{
    protected $requestStack;

    protected $activeTree;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    protected function loadActiveTreeForMenu(Menu $menu)
    {
        $urlCible = $this->requestStack->getCurrentRequest()->getPathInfo();
        foreach ($menu->getItems() as $item) {
            if ($item->getUrl() == $urlCible) {
                $this->loadActiveTreeForItem($item);
                break;
            }
        }
    }

    protected function loadActiveTreeForItem(MenuItem $item)
    {
        $activeTree = array();
        $activeTree[] = $item->getUrl();
        while ($item = $item->getParent()) {
            $activeTree[] = $item->getUrl();
        }
        $this->activeTree = $activeTree;
    }

    public function isInActiveTree(MenuItem $item)
    {
        if (is_null($this->activeTree)) {
            $this->loadActiveTreeForMenu($item->getMenu());
        }

        $urlCible = $item->getUrl();
        if (in_array($urlCible, $this->activeTree)) {
            return true;
        }

        return false;
    }
}
