<?php

namespace Id4v\Bundle\MenuBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MenuItemAdminController extends Controller
{
    /**
     * Redirect the user depend on this choice.
     *
     * @param object $object
     *
     * @return RedirectResponse
     */
    protected function redirectTo($object)
    {
        $url = false;

        if (null !== $this->get('request')->get('btn_update_and_list')) {
            $url = $this->redirectToMenu('admin_id4v_menu_menu_organize', $object);
        }
        if (null !== $this->get('request')->get('btn_create_and_list')) {
            $url = $this->redirectToMenu('admin_id4v_menu_menu_organize', $object);
        }

        if (null !== $this->get('request')->get('btn_create_and_create')) {
            $params = array();
            if ($this->admin->hasActiveSubClass()) {
                $params['subclass'] = $this->get('request')->get('subclass');
            }
            $url = $this->admin->generateUrl('create', $params);
        }

        if ($this->getRestMethod() == 'DELETE') {
            $url = $this->redirectToMenu('admin_id4v_menu_menu_organize', $object);
        }

        if (!$url) {
            $url = $this->admin->generateObjectUrl('edit', $object);
        }

        return new RedirectResponse($url);
    }

    private function redirectToMenu($path, $object)
    {
        return $this->generateUrl($path, array('id' => $object->getMenu()->getId()));
    }
}
