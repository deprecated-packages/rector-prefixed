<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210318\Symfony\Component\HttpKernel\EventListener;

use RectorPrefix20210318\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use RectorPrefix20210318\Symfony\Component\HttpFoundation\Request;
use RectorPrefix20210318\Symfony\Component\HttpFoundation\RequestStack;
use RectorPrefix20210318\Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use RectorPrefix20210318\Symfony\Component\HttpKernel\Event\KernelEvent;
use RectorPrefix20210318\Symfony\Component\HttpKernel\Event\RequestEvent;
use RectorPrefix20210318\Symfony\Component\HttpKernel\KernelEvents;
use RectorPrefix20210318\Symfony\Component\Routing\RequestContextAwareInterface;
/**
 * Initializes the locale based on the current request.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class LocaleListener implements \RectorPrefix20210318\Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    private $router;
    private $defaultLocale;
    private $requestStack;
    public function __construct(\RectorPrefix20210318\Symfony\Component\HttpFoundation\RequestStack $requestStack, string $defaultLocale = 'en', \RectorPrefix20210318\Symfony\Component\Routing\RequestContextAwareInterface $router = null)
    {
        $this->defaultLocale = $defaultLocale;
        $this->requestStack = $requestStack;
        $this->router = $router;
    }
    /**
     * @param \Symfony\Component\HttpKernel\Event\KernelEvent $event
     */
    public function setDefaultLocale($event)
    {
        $event->getRequest()->setDefaultLocale($this->defaultLocale);
    }
    /**
     * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
     */
    public function onKernelRequest($event)
    {
        $request = $event->getRequest();
        $this->setLocale($request);
        $this->setRouterContext($request);
    }
    /**
     * @param \Symfony\Component\HttpKernel\Event\FinishRequestEvent $event
     */
    public function onKernelFinishRequest($event)
    {
        if (null !== ($parentRequest = $this->requestStack->getParentRequest())) {
            $this->setRouterContext($parentRequest);
        }
    }
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    private function setLocale($request)
    {
        if ($locale = $request->attributes->get('_locale')) {
            $request->setLocale($locale);
        }
    }
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    private function setRouterContext($request)
    {
        if (null !== $this->router) {
            $this->router->getContext()->setParameter('_locale', $request->getLocale());
        }
    }
    public static function getSubscribedEvents() : array
    {
        return [\RectorPrefix20210318\Symfony\Component\HttpKernel\KernelEvents::REQUEST => [
            ['setDefaultLocale', 100],
            // must be registered after the Router to have access to the _locale
            ['onKernelRequest', 16],
        ], \RectorPrefix20210318\Symfony\Component\HttpKernel\KernelEvents::FINISH_REQUEST => [['onKernelFinishRequest', 0]]];
    }
}
