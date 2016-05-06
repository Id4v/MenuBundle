<?php

namespace Id4v\Bundle\MenuBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Id4v\Bundle\MenuBundle\Entity\Menu;
use Symfony\Component\HttpFoundation\Request;

class MenuAdminController extends Controller
{
    protected function getMenuManager()
    {
        return $this->get('id4v.menu.manager');
    }
}
