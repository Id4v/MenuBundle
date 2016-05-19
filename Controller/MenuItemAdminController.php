<?php

namespace Id4v\Bundle\MenuBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MenuItemAdminController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateItemAction(Request $request)
    {
        $id = $request->get('id');
        $parent = $request->get('parent');
        $position = $request->get('position');
        $item = $this->getItem($id, $em, $repo);
        if (!$item) {
            return $this->getResponse(false);
        }
        if (isset($parent)) {
            $item->setParent($repo->find($parent));
        } else {
            $item->setParent(null);
        }
        $item->setPosition($position);
        $em->persist($item);
        $em->flush();

        return $this->getResponse(true);
    }

    /**
     * @param bool $isSuccess
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    protected function getResponse($isSuccess)
    {
        $response = new JsonResponse();
        if ($isSuccess) {
            $response->setStatusCode(200, 'Item Updated');
            $response->setData(
                array(
                    'state' => 'success',
                    'message' => $this->get('translator')->trans('menu.menu_item.updated', array(), 'Id4vMenuBundle'),
                )
            );

            return $response;
        } else {
            $response->setStatusCode(200, 'Item not found');
            $response->setData(array(
                'state' => 'danger',
                'message' => $this->get('translator')->trans('menu.menu_item.error', array(), 'Id4vMenuBundle'),
            ));

            return $response;
        }
    }

    /**
     * @param int              $id   int
     * @param EntityManager    $em
     * @param EntityRepository $repo
     *
     * @return \Id4v\Bundle\MenuBundle\Entity\MenuItem
     */
    protected function getItem($id, &$em, &$repo)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('Id4vMenuBundle:MenuItem');
        $item = $repo->find($id);

        return $item;
    }
}
