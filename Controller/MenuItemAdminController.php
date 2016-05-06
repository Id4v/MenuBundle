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
            return $response->setStatusCode(500,"Item not found");
        }
        if(isset($parent)) {
            $item->setParent($repo->find($parent));
        }else{
            $item->setParent(null);
        }
        $item->setPosition($position);
        $em->persist($item);
        $em->flush();
        $response->setStatusCode(200);
        $response->setData(json_encode($item));
        return $response;
    }
}
