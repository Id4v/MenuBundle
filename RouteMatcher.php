<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 08/04/15
 * Time: 21:49
 */

namespace Id4v\Bundle\MenuBundle;


use Id4v\Bundle\MenuBundle\Entity\Menu;
use Id4v\Bundle\MenuBundle\Entity\MenuItem;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class RouteMatcher {

    private $container;
    private $activeTree;

    function __construct(ContainerInterface $container)
    {
        $this->container=$container;
    }

    protected function loadActiveTreeForMenu(Menu $menu){

        $urlCible=$this->container->get("request")->getPathInfo();
        foreach($menu->getItems() as $item){
            if($item->getUrl() == $urlCible){
                $this->loadActiveTreeForItem($item);
                break;
            }
        }
    }

    protected function loadActiveTreeForItem(MenuItem $item){
        $activeTree=array();
        $activeTree[]=$item->getUrl();
        while($item=$item->getParent()){
            $activeTree[]=$item->getUrl();
        }
        $this->activeTree=$activeTree;
    }

    public function isInActiveTree(MenuItem $item)
    {
        if(is_null($this->activeTree)){
            $this->loadActiveTreeForMenu($item->getMenu());
        }

        $urlCible=$item->getUrl();
        if(in_array($urlCible,$this->activeTree)){
            return true;
        }

        return false;
    }


}