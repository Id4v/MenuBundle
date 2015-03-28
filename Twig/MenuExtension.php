<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 23/02/15
 * Time: 22:07
 */

namespace Id4v\Bundle\MenuBundle\Twig;


use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig_Environment;

class MenuExtension extends \Twig_Extension {

    protected $doctrine;
    protected $router;
    /**
     * @var Twig_Environment $env
     */
    protected $env;

    function __construct(RegistryInterface $doctrine,RouterInterface $router)
    {
        $this->doctrine=$doctrine;
        $this->router=$router;
    }

    public function initRuntime(Twig_Environment $environment)
    {
        $this->env=$environment;
    }


    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction("render_menu",
              array(
                $this,
                'renderMenu'
              ),
              array(
                'is_safe' => array('html')
              )
            )
        );
    }

    /**
     * Render the menu given the machine_name
     * You can specify the markup to use in the options
     * Defaults:
     *  * template : "Id4vMenuBundle:Block:menu.html.twig"
     * @param $machineName
     * @param $options
     * @return string
     */
    public function renderMenu($machineName,$options=array()){
        $template="Id4vMenuBundle:Block:menu.html.twig";


        foreach($options as $key=>$value){
            $$key=$value;
        }


        $menu=$this->doctrine->getRepository("Id4vMenuBundle:Menu")->findOneBy(array("slug"=>$machineName));
        if(!$menu){
            return "";
        }
        $items=$menu->getFirstLevelItems();

        return $this->env->render($template,array("items"=>$items));
    }


    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "menu_extension";
    }
}
