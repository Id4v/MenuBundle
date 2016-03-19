<?php

namespace Id4v\Bundle\MenuBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class MenuItemAdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function redirectTo($object, Request $request = null)
    {
        $url = false;

        if (null !== $request->get('btn_update_and_list')) {
            $url = $this->redirectToMenu('admin_id4v_menu_menu_organize', $object);
        }
        if (null !== $request->get('btn_create_and_list')) {
            $url = $this->redirectToMenu('admin_id4v_menu_menu_organize', $object);
        }

        if (null !== $request->get('btn_create_and_create')) {
            $params = array();
            if ($this->admin->hasActiveSubClass()) {
                $params['subclass'] = $request->get('subclass');
            }
            $url = $this->admin->generateUrl('create', $params);
        }

        if ($this->getRestMethod() == 'DELETE') {
            $url = $this->redirectToMenu('admin_id4v_menu_menu_organize', $object);
        }

        if (!$url) {
            foreach (array('edit', 'show') as $route) {
                if ($this->admin->hasRoute($route) && $this->admin->isGranted(strtoupper($route), $object)) {
                    $url = $this->admin->generateObjectUrl($route, $object);
                    break;
                }
            }
        }

        return new RedirectResponse($url);
    }

    private function redirectToMenu($path, $object)
    {
        return $this->generateUrl($path, array('id' => $object->getMenu()->getId()));
    }
}
