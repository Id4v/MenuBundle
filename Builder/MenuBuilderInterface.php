<?php

namespace Id4v\Bundle\MenuBundle\Builder;

interface MenuBuilderInterface
{
    public function buildMenu($rootNode, $items);
}
