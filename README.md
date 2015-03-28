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

2 Activate the bundle in your AppKernel.php file

```php
public function registerBundles()
    {
        $bundles = array(
        ...
        new \Id4v\Bundle\MenuBundle\Id4vMenuBundle(),
        ...
        );
        return $bundles
    }
```
3 Register the ```id4v_menu.admin.menu``` Service to your sonata admin configuration

4 Profit!

## Usage
**Create your menu in the admin of your website.**
![Image Admin Menu]
(http://shareimg.co/thumbs/7/142692966462-0.png)

**Organize your menu by adding MenuItems, drag and dropping them**
![Image Organize Menu]
(http://shareimg.co/thumbs/8/1426929968174-0.png)

**Render your Menu in twig templates like this**
```twig
{{ render_menu("menu-principal",{template: "Id4vMenuBundle:Block:menu.html.twig"}) }}
```
Options to this functions are :
* template:  the template you want to use to render the menu *(default is "Id4vMenuBundle:Block:menu.html.twig")




