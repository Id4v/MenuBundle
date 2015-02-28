<?php

namespace Overscan\Bundle\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Overscan\Bundle\MenuBundle\Entity\MenuItem;

/**
 * Menu
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Overscan\Bundle\MenuBundle\Entity\MenuRepository")
 */
class Menu
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="menu", cascade={"persist","remove","merge"}, orphanRemoval=true)
     * @ORM\OrderBy({ "depth" = "ASC","position" = "ASC" })
     */
    private $items;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Menu
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Menu
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add items
     *
     * @param \Overscan\Bundle\MenuBundle\Entity\MenuItem $items
     * @return Menu
     */
    public function addItem(\Overscan\Bundle\MenuBundle\Entity\MenuItem $items)
    {
        $this->items[] = $items;

        return $this;
    }

    /**
     * Remove items
     *
     * @param \Overscan\Bundle\MenuBundle\Entity\MenuItem $items
     */
    public function removeItem(\Overscan\Bundle\MenuBundle\Entity\MenuItem $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }

    function __toString()
    {
        return $this->name."";
    }

    public function getHierarchy(){
        $retour=array();
        $items=$this->getItems();
        foreach($items as $item){
            if($item->getParent()==null)
                $this->getHierarchyFromNode($item,$retour);
        }
        return $retour;
    }

    public function getHierarchyFromNode($node,&$retour){
        $retour[]=$node;
        if($node->hasChildren()){
            foreach($node->getChildren() as $child) {
                $this->getHierarchyFromNode($child, $retour);
            }
        }
    }
}
