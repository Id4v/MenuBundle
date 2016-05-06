<?php

namespace Id4v\Bundle\MenuBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class MenuItemAdminController extends Controller
{
    public function updateItemAction(Request $request)
    {
        $id=$request->get("id");
        $parent=$request->get("parent");
        $position=$request->get("position");
        
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository("Id4vMenuBundle:MenuItem");
        $item=$repo->find($id);
        $response=new JsonResponse();
        if(!$item){
            $response->setStatusCode(200,"Item not found");
            $response->setData(array(
                "state"=>"danger",
                "message"=>$this->get("translator")->trans("menu.menu_item.error",array(),"Id4vMenuBundle")
            ));
            return $response;
        }
        if(isset($parent)) {
            $item->setParent($repo->find($parent));
        }else{
            $item->setParent(null);
        }
        $item->setPosition($position);
        $em->persist($item);
        $em->flush();
        $response->setStatusCode(200,"Item Updated");
        $response->setData(
            array(
                "state"=>"success",
                "message"=>$this->get("translator")->trans("menu.menu_item.updated",array(),"Id4vMenuBundle")
            )
        );
        return $response;
    }
}
