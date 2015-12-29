[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d95d8fb7-d620-4c20-a46c-5bb89cdb2a01/small.png)](https://insight.sensiolabs.com/projects/d95d8fb7-d620-4c20-a46c-5bb89cdb2a01)

# MenuBundle
Id4vMenuBundle is a Symfony2 bundle to manage menus easily

## How it works
A Menu is a tree of MenuItems

MenuItems are 
* A label to display
  * Optionally an icon to show
* A link to go when clicked

## Installation
1 Install it using composer
```bash
composer require id4v/menu-bundle
```

2 Activate the bundle in your `AppKernel.php` file

```php
public function registerBundles()
    {
        $bundles = array(
        ...
        # if you haven't already this bundle
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
        ...
        new \Id4v\Bundle\MenuBundle\Id4vMenuBundle(),
        ...
        );
        return $bundles
    }
```
3 Add this mandatory configuration for the `StofDoctrineExtensionsBundle` in your `config.yml`
```yml
stof_doctrine_extensions:
    orm:
        default:
            sluggable: true
```

4 Register the `id4v_menu.admin.menu` Service to your sonata admin configuration

5 Profit!

## Usage
####Create your menu in the admin of your website.

####Organize your menu by adding MenuItems, drag and dropping them

####Render your Menu in twig templates

####Full exemple of implementation

```twig
{{ knp_menu_render("app.menu.main", {template: "Id4vMenuBundle:Menu:main.html.twig"}) }}
```
or
```twig
{{ knp_menu_render("app.menu.main", {template: "menu:main.html.twig"}) }}
```

All documentation for this tag is available here : [KnpMenuBundle](http://symfony.com/doc/master/bundles/KnpMenuBundle/index.html).

A base builder as been added to help common usage of menu creation, the `BaseMenuBuilder.php` class.

First of all the basic declaration of your builder can be :
 
```php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Doctrine\ORM\EntityManager;
use Id4v\Bundle\MenuBundle\Builder\BaseMenuBuilder;

class AppMenuBuilder extends BaseMenuBuilder
{
    public function __construct(FactoryInterface $factory, EntityManager $em)
    {
        parent::__construct($factory, $em);
    }

    public function createMainMenu()
    {
        return $this->getSimpleMenu('main-menu');
    }
}
```

You can now declare yours services :

```yml
services:
    app.menu_builder:
        class: AppBundle\Menu\AppMenuBuilder
        arguments: ["@knp_menu.factory", "@doctrine.orm.entity_manager"]

    app.menu.main:
        class: Knp\Menu\MenuItem # the service definition requires setting the class
        factory: ["@app.menu_builder", createMainMenu]
        arguments: ["@request_stack"]
        tags:
            - { name: knp_menu.menu, alias: app.menu.main }
```

You can consult documentation of this declaration in [KnpMenuBundle Doc](http://symfony.com/doc/master/bundles/KnpMenuBundle/index.html).

Moreover you can activate an URI matcher or adapt one on your need.

```yml
services:
    app.voter.regex:
        class: Id4v\Bundle\MenuBundle\Matcher\Voter\UriVoter
        arguments: ["@request_stack"]
        tags:
            - { name: knp_menu.voter }
``` 

## Sonata Admin

Sometimes you get an abundant tree into your menus. And the performance of the administration get found affected.
It's the reason why existing a configuration with the bundle.

By default you can only drap and drop two levels depth. If you want to change it, modify the `menu_depth` node.

__Default Configuration__

```yml
id4v_menu:
    admin:
        menu_depth: 2
```
