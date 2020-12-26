<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix2020DecSat\Symfony\Component\HttpKernel\EventListener;

use RectorPrefix2020DecSat\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use RectorPrefix2020DecSat\Symfony\Component\HttpFoundation\Request;
use RectorPrefix2020DecSat\Symfony\Component\HttpFoundation\RequestStack;
use RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Event\KernelEvent;
use RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Event\RequestEvent;
use RectorPrefix2020DecSat\Symfony\Component\HttpKernel\KernelEvents;
use RectorPrefix2020DecSat\Symfony\Component\Routing\RequestContextAwareInterface;
/**
 * Initializes the locale based on the current request.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class LocaleListener implements \RectorPrefix2020DecSat\Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    private $router;
    private $defaultLocale;
    private $requestStack;
    public function __construct(\RectorPrefix2020DecSat\Symfony\Component\HttpFoundation\RequestStack $requestStack, string $defaultLocale = 'en', \RectorPrefix2020DecSat\Symfony\Component\Routing\RequestContextAwareInterface $router = null)
    {
        $this->defaultLocale = $defaultLocale;
        $this->requestStack = $requestStack;
        $this->router = $router;
    }
    public function setDefaultLocale(\RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Event\KernelEvent $event)
    {
        $event->getRequest()->setDefaultLocale($this->defaultLocale);
    }
    public function onKernelRequest(\RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Event\RequestEvent $event)
    {
        $request = $event->getRequest();
        $this->setLocale($request);
        $this->setRouterContext($request);
    }
    public function onKernelFinishRequest(\RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Event\FinishRequestEvent $event)
    {
        if (null !== ($parentRequest = $this->requestStack->getParentRequest())) {
            $this->setRouterContext($parentRequest);
        }
    }
    private function setLocale(\RectorPrefix2020DecSat\Symfony\Component\HttpFoundation\Request $request)
    {
        if ($locale = $request->attributes->get('_locale')) {
            $request->setLocale($locale);
        }
    }
    private function setRouterContext(\RectorPrefix2020DecSat\Symfony\Component\HttpFoundation\Request $request)
    {
        if (null !== $this->router) {
            $this->router->getContext()->setParameter('_locale', $request->getLocale());
        }
    }
    public static function getSubscribedEvents() : array
    {
        return [\RectorPrefix2020DecSat\Symfony\Component\HttpKernel\KernelEvents::REQUEST => [
            ['setDefaultLocale', 100],
            // must be registered after the Router to have access to the _locale
            ['onKernelRequest', 16],
        ], \RectorPrefix2020DecSat\Symfony\Component\HttpKernel\KernelEvents::FINISH_REQUEST => [['onKernelFinishRequest', 0]]];
    }
}
