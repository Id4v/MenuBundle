<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 30/04/2016
 * Time: 21:47
 */

namespace Id4v\Bundle\MenuBundle\Provider;


use Doctrine\Bundle\DoctrineBundle\Registry;
use Id4v\Bundle\MenuBundle\Builder\MenuBuilderInterface;
use Id4v\Bundle\MenuBundle\Entity\Menu;
use Id4v\Bundle\MenuBundle\Loader\MenuLoaderInterface;
use Knp\Menu\MenuFactory;
use Knp\Menu\Provider\MenuProviderInterface;

class Id4vMenuProvider implements MenuProviderInterface
{

    private $loader;

    private $builder;

    private $factory;

    public function __construct(MenuLoaderInterface $loader,MenuBuilderInterface $builder,MenuFactory $factory)
    {
        $this->loader=$loader;
        $this->builder= $builder;
        $this->factory= $factory;
    }


    /**
     * Retrieves a menu by its name
     *
     * @param string $name
     * @param array $options
     *
     * @return \Knp\Menu\ItemInterface
     * @throws \InvalidArgumentException if the menu does not exists
     */
    public function get($name, array $options = array())
    {
        /** @var Menu $menu */
        $menu=$this->factory->createItem("root");

        $nodes=$this->loader->load($name);
        if (empty($nodes)) {
            return $menu;
        }

        $menu=$this->builder->buildMenu($menu, $nodes);

        return $menu;
    }

    /**
     * Checks whether a menu exists in this provider
     *
     * @param string $name
     * @param array $options
     *
     * @return boolean
     */
    public function has($name, array $options = array())
    {
        return $this->loader->exists($name);
    }
}