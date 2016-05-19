<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 30/04/2016
 * Time: 23:02.
 */

namespace Id4v\Bundle\MenuBundle\Builder;

interface MenuBuilderInterface
{
    public function buildMenu($rootNode, $items);
}
