<?php

namespace Id4v\Bundle\MenuBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Id4v\Bundle\MenuBundle\Form\Type\MenuItemOrderingType;
use Id4v\Bundle\MenuBundle\Entity\Menu;
use Symfony\Component\HttpFoundation\Request;

class MenuAdminController extends Controller
{
    public function organizeAction(Request $request, Menu $menu)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('Id4vMenuBundle:MenuItem');

        if ($node = $request->get('elem')) {
            $items = $repo->find($node)->getChildren();
        } else {
            $items = $repo->getRootNodesBySlug($menu->getSlug());
        }

        $forms = array();
        foreach ($items as $id => $item) {
            $form = $this->createForm(new MenuItemOrderingType(), $item);
            $forms[] = $form->createView();
        }

        return $this->render('Id4vMenuBundle:CRUD:menu_organize_element.html.twig',
            array(
                'menu' => $menu,
                'forms' => $forms,
            )
        );
    }

    public function updateItemsAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManagerForClass('Id4vMenuBundle:MenuItem');
        $repo = $this->getDoctrine()->getRepository('Id4vMenuBundle:MenuItem');
        foreach ($request->request->all() as $param) {
            $parent = $repo->find($param['parent']);
            $item = $repo->find($param['id']);
            $item->setDepth($param['depth']);
            $item->setPosition($param['position']);
            $item->setParent($parent);
            $em->persist($item);
        }
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', 'Menu modifié avec succès');

        return $this->redirect($this->generateUrl('admin_id4v_menu_menu_organize', array('id' => $request->get('id'))));
    }
}
