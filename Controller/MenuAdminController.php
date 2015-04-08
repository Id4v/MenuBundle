<?php

namespace Id4v\Bundle\MenuBundle\Controller;

use Id4v\Bundle\MenuBundle\Entity\MenuItem;
use Id4v\Bundle\MenuBundle\Form\Type\MenuItemOrderingType;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Id4v\Bundle\MenuBundle\Form\Type\MenuItemType;

class MenuAdminController extends Controller
{
    public function organizeAction(Request $request)
    {
        $idMenu=$request->get("id");

        $menu=$this->getDoctrine()->getRepository("Id4vMenuBundle:Menu")->find($idMenu);

        $items=$menu->getHierarchy(false);

        $forms=array();
        foreach($items as $id=>$item){
            $form=$this->createForm(new MenuItemOrderingType(),$item);
            $forms[]=$form->createView();
        }

        return $this->render("Id4vMenuBundle:CRUD:menu_organize_element.html.twig",
          array(
            "menu"=>$menu,
            "forms"=>$forms
          )
        );
    }

    public function updateItemsAction(Request $request){

        $em=$this->getDoctrine()->getEntityManagerForClass("Id4vMenuBundle:MenuItem");
        $repo=$this->getDoctrine()->getRepository("Id4vMenuBundle:MenuItem");
        foreach($request->request->all() as $param){
            $parent=$repo->find($param["parent"]);
            $item=$repo->find($param["id"]);
            $item->setDepth($param["depth"]);
            $item->setPosition($param["position"]);
            $item->setParent($parent);
            $em->persist($item);
        }
        $em->flush();
        $request->getSession()->getFlashBag()->add("success","Menu modifié");
        return $this->redirect($this->generateUrl('admin_id4v_menu_menu_organize',array("id"=>$request->get("id"))));
    }

    private function fetchMenuById($idMenu){
        $repoMenu=$this->getDoctrine()->getRepository("Id4vMenuBundle:Menu");
        $menu=$repoMenu->find($idMenu);
        return $menu;
    }

    public function addItemAction(Request $request){
        $em=$this->getDoctrine()->getManagerForClass("Id4vMenuBundle:MenuItem");
        $item=new MenuItem();
        $idMenu=$request->get("id");
        $menu=$this->fetchMenuById($idMenu);
        if($menu){
            $item->setMenu($menu);
            $item->setPosition(1);
            $item->setDepth(1);
        }
        $form=$this->createForm(new MenuItemType(),$item);
        if($request->isMethod("POST")){
            $form->handleRequest($request);
            if($form->isValid()){
                $em->persist($item);
                $em->flush();
                $request->getSession()->getFlashBag()->add("success","Elément ajouté au Menu");
                return $this->redirect($this->generateUrl('admin_id4v_menu_menu_organize',array("id"=>$idMenu)));
            }
        }
        return $this->render("Id4vMenuBundle:CRUD:menu_add_element.html.twig",array("form"=>$form->createView()));
    }

    public function deleteItemAction(Request $request){
        $em=$this->getDoctrine()->getEntityManagerForClass("Id4vMenuBundle:MenuItem");
        $repoItem=$em->getRepository("Id4vMenuBundle:MenuItem");
        $item=$repoItem->find($request->get("id"));
        $idMenu=$item->getMenu()->getId();

        if($request->isMethod("DELETE")){
            $em->remove($item);
            $em->flush();
            $request->getSession()->getFlashBag()->add("success","Elément ajouté au Menu");

            return $this->redirect($this->generateUrl('admin_id4v_menu_menu_organize',array("id"=>$idMenu)));
        }

        return $this->render("Id4vMenuBundle:CRUD:menu_delete_element.html.twig",array("item"=>$item));
    }

    public function editItemAction(Request $request){
        $em=$this->getDoctrine()->getEntityManagerForClass("Id4vMenuBundle:MenuItem");
        $repoItem=$em->getRepository("Id4vMenuBundle:MenuItem");
        $item=$repoItem->find($request->get("id"));
        $idMenu=$item->getMenu()->getId();

        $form=$this->createForm(new MenuItemType(),$item);

        if($request->isMethod("POST")){
            $form->handleRequest($request);
            if($form->isValid()){

                $em->persist($item);
                $em->flush();

                $request->getSession()->getFlashBag()->add("success","Elément ajouté au Menu");

                return $this->redirect($this->generateUrl('admin_id4v_menu_menu_organize',array("id"=>$idMenu)));
            }
        }
        return $this->render("Id4vMenuBundle:CRUD:menu_edit_element.html.twig",array("form"=>$form->createView()));
    }
}
