<?php

namespace Id4v\Bundle\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * MenuItem.
 *
 * @ORM\Table("menu__menu_item")
 * @ORM\Entity(repositoryClass="Id4v\Bundle\MenuBundle\Entity\MenuItemRepository")
 */
class MenuItem
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;

    /**
     * @var string
     *
     * @ORM\Column(name="target", type="string", length=255, nullable=true)
     */
    private $target = "_self";

    /**
     * @Gedmo\SortablePosition
     *
     * @var int
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position;

    /**
     * @var int
     * @ORM\Column(name="depth", type="integer", nullable=false)
     */
    private $depth = 1;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="MenuItem", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="parent", cascade={"persist"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Id4v\Bundle\MenuBundle\Entity\Menu", inversedBy="items")
     */
    private $menu;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return MenuItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return MenuItem
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set active.
     *
     * @param bool $active
     *
     * @return MenuItem
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set target.
     *
     * @param array $target
     *
     * @return MenuItem
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target.
     *
     * @return array
     */
    public function getTarget()
    {
        return $this->target;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set parent.
     *
     * @param \Id4v\Bundle\MenuBundle\Entity\MenuItem $parent
     *
     * @return MenuItem
     */
    public function setParent(\Id4v\Bundle\MenuBundle\Entity\MenuItem $parent = null)
    {
        $this->parent = $parent;
        $this->updateDepth();

        return $this;
    }

    /**
     * Get parent.
     *
     * @return \Id4v\Bundle\MenuBundle\Entity\MenuItem
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children.
     *
     * @param \Id4v\Bundle\MenuBundle\Entity\MenuItem $children
     *
     * @return MenuItem
     */
    public function addChild(\Id4v\Bundle\MenuBundle\Entity\MenuItem $children)
    {
        $children->setParent($this);
        $children->setMenu($this->getMenu());

        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children.
     *
     * @param \Id4v\Bundle\MenuBundle\Entity\MenuItem $children
     */
    public function removeChild(\Id4v\Bundle\MenuBundle\Entity\MenuItem $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set menu.
     *
     * @param \Id4v\Bundle\MenuBundle\Entity\Menu $menu
     *
     * @return MenuItem
     */
    public function setMenu(\Id4v\Bundle\MenuBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu.
     *
     * @return \Id4v\Bundle\MenuBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    public function __toString()
    {
        return $this->title.'';
    }

    /**
     * Set position.
     *
     * @param int $position
     *
     * @return MenuItem
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set depth.
     *
     * @param int $depth
     *
     * @return MenuItem
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * Get depth.
     *
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Update the depth compared to the parent.
     */
    public function updateDepth()
    {
        $item = $this;
        $depth = 1;

        while ($item->parent !== null) {
            $depth++;
            $item = $item->parent;
        }

        $this->setDepth($depth);
    }

    public function hasChildren()
    {
        return count($this->children) > 0;
    }
}
