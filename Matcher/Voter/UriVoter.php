<?php

namespace Id4v\Bundle\MenuBundle\Matcher\Voter;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class UriVoter implements VoterInterface {

    private $requestStack;

    function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function matchItem(ItemInterface $item)
    {
        if (null === $this->getRequestUri() || null === $item->getUri()) {
            return null;
        }

        if ($item->getUri() === $this->getRequestUri()) {
            return true;
        }

        return null;
    }

    private function getRequestUri()
    {
        return $this->requestStack->getCurrentRequest()->getPathInfo();
    }
}