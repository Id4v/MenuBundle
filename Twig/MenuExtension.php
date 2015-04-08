<?php

/**
 * Created by PhpStorm.
 * User: david
 * Date: 23/02/15
 * Time: 22:07.
 */

namespace Id4v\Bundle\MenuBundle\Twig;

use Id4v\Bundle\MenuBundle\RouteMatcher;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Twig_Environment;

class MenuExtension extends \Twig_Extension
{
    protected $doctrine;
    protected $matcher;
    /**
     * @var Twig_Environment
     */
    protected $env;

    public function __construct(RegistryInterface $doctrine, RouteMatcher $matcher)
    {
        $this->doctrine = $doctrine;
        $this->matcher = $matcher;
    }

    public function initRuntime(Twig_Environment $environment)
    {
        $this->env = $environment;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('render_menu',
              array(
                $this,
                'renderMenu',
              ),
              array(
                'is_safe' => array('html'),
              )
            ),
        );
    }

    /**
     * Render the menu given the machine_name
     * You can specify the markup to use in the options
     * Defaults:
     *  * template : "Id4vMenuBundle:Block:menu.html.twig".
     *
     * @param $machineName
     * @param $options
     *
     * @return string
     */
    public function renderMenu($machineName, $options = array())
    {
        $template = 'Id4vMenuBundle:Block:menu.html.twig';

        foreach ($options as $key => $value) {
            $$key = $value;
        }

        $menu = $this->doctrine->getRepository('Id4vMenuBundle:Menu')->findOneBy(array('slug' => $machineName));
        if (!$menu) {
            return '';
        }
        $items = $menu->getFirstLevelItems();

        return $this->env->render($template, array('items' => $items, 'matcher' => $this->matcher));
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'menu_extension';
    }
}
