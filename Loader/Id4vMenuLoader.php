<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 30/04/2016
 * Time: 22:04
 */

namespace Id4v\Bundle\MenuBundle\Loader;


use Doctrine\Bundle\DoctrineBundle\Registry;
use Knp\Menu\MenuFactory;

class Id4vMenuLoader implements MenuLoaderInterface
{

    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|\Id4v\Bundle\MenuBundle\Entity\MenuRepository
     */
    private $repository;


    public function __construct(Registry $doctrine)
    {
        $this->doctrine=$doctrine;
        $this->repository=$doctrine->getRepository("Id4vMenuBundle:Menu");
    }


    public function load($name)
    {
        $nodes=$this->doctrine->getRepository("Id4vMenuBundle:MenuItem")->getRootNodesBySlug($name);
        return $nodes;
    }

    public function exists($name)
    {
        return $this->repository->findOneBy(array("slug"=>$name)) !== null;
    }
}