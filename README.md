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
**Create your menu in the admin of your website.**
![Image Admin Menu]
(http://shareimg.co/thumbs/7/142692966462-0.png)

**Organize your menu by adding MenuItems, drag and dropping them**
![Image Organize Menu]
(http://shareimg.co/thumbs/8/1426929968174-0.png)

**Render your Menu in twig templates like this**
```twig
{{ knp_menu_render("menu-principal",{template: "Id4vMenuBundle:Block:menu.html.twig"}) }}
```

All documentation for this tag is available here : [KnpMenuBundle](http://symfony.com/doc/master/bundles/KnpMenuBundle/index.html)

A base builder as been added to help common usage of menu creation, extends `BaseMenuBuilder.php`

The basic declaration for example is : 

```yml
app.menu.your_builder:
    class: AppBundle\Menu\YourMenuBuilder
    arguments: ["@knp_menu.factory", "@doctrine.orm.entity_manager"]
``` 

Sometimes you get an abundant tree into your menus. And the performance of the administration get found affected.
It's the reason why existing a configuration with the bundle.

By default you can only drap and drop two levels depth. If you want to change it, modify the `menu_depth` node.

__Default Configuration__
```yml
id4v_menu:
    admin:
        menu_depth: 2
```
