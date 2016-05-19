<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 30/04/2016
 * Time: 22:03.
 */

namespace Id4v\Bundle\MenuBundle\Loader;

interface MenuLoaderInterface
{
    public function load($name);
    public function exists($name);
}
