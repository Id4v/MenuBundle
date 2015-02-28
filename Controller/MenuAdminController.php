<?php

namespace Overscan\Bundle\MenuBundle\Controller;

use Overscan\Bundle\MenuBundle\Entity\MenuItem;
use Overscan\Bundle\MenuBundle\Form\MenuItemOrderingType;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Overscan\Bundle\MenuBundle\Form\MenuItemType;

class MenuAdminController extends Controller
{
    public function organizeAction(Request $request)
    {
        $idMenu=$request->get("id");

        $menu=$this->getDoctrine()->getRepository("OverscanMenuBundle:Menu")->find($idMenu);

        $items=$menu->getHierarchy();
        //var_dump($items);

        $forms=array();
        foreach($items as $id=>$item){
            $form=$this->createForm(new MenuItemOrderingType(),$item);
            $forms[]=$form->createView();
        }

        return $this->render("OverscanMenuBundle:CRUD:admin_arrange.html.twig",
          array(
            "menu"=>$menu,
            "forms"=>$forms
          )
        );
    }

    public function updateItemsAction(Request $request){

        $em=$this->getDoctrine()->getEntityManagerForClass("OverscanMenuBundle:MenuItem");
        $repo=$this->getDoctrine()->getRepository("OverscanMenuBundle:MenuItem");
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
        return $this->redirect($this->generateUrl('admin_overscan_menu_menu_organize',array("id"=>$request->get("id"))));
    }

    public function addItemAction(Request $request){
        $em=$this->getDoctrine()->getManagerForClass("OverscanMenuBundle:MenuItem");

        $item=new MenuItem();


        $idMenu=$request->get("id");
        $repoMenu=$this->getDoctrine()->getRepository("OverscanMenuBundle:Menu");
        $menu=$repoMenu->find($idMenu);
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

                return $this->redirect($this->generateUrl('admin_overscan_menu_menu_organize',array("id"=>$idMenu)));
            }
        }

        return $this->render("OverscanMenuBundle:CRUD:admin_addItem.html.twig",array("form"=>$form->createView()));
    }

    public function deleteItemAction(Request $request){
        $em=$this->getDoctrine()->getEntityManagerForClass("OverscanMenuBundle:MenuItem");
        $repoItem=$em->getRepository("OverscanMenuBundle:MenuItem");
        $item=$repoItem->find($request->get("id"));
        $idMenu=$item->getMenu()->getId();

        if($request->isMethod("DELETE")){
            $em->remove($item);
            $em->flush();
            $request->getSession()->getFlashBag()->add("success","Elément ajouté au Menu");

            return $this->redirect($this->generateUrl('admin_overscan_menu_menu_organize',array("id"=>$idMenu)));
        }

        return $this->render("OverscanMenuBundle:CRUD:admin_delItem.html.twig",array("item"=>$item));
    }

    public function editItemAction(Request $request){
        $em=$this->getDoctrine()->getEntityManagerForClass("OverscanMenuBundle:MenuItem");
        $repoItem=$em->getRepository("OverscanMenuBundle:MenuItem");
        $item=$repoItem->find($request->get("id"));
        $idMenu=$item->getMenu()->getId();

        $form=$this->createForm(new MenuItemType(),$item);

        if($request->isMethod("POST")){
            $form->handleRequest($request);
            if($form->isValid()){

                $em->persist($item);
                $em->flush();

                $request->getSession()->getFlashBag()->add("success","Elément ajouté au Menu");

                return $this->redirect($this->generateUrl('admin_overscan_menu_menu_organize',array("id"=>$idMenu)));
            }
        }
        return $this->render("OverscanMenuBundle:CRUD:admin_addItem.html.twig",array("form"=>$form->createView()));
    }
}