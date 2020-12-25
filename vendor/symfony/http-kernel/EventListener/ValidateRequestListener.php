<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\EventListener;

use _PhpScoperbf340cb0be9d\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use _PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Event\RequestEvent;
use _PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\KernelEvents;
/**
 * Validates Requests.
 *
 * @author Magnus Nordlander <magnus@fervo.se>
 *
 * @final
 */
class ValidateRequestListener implements \_PhpScoperbf340cb0be9d\Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    /**
     * Performs the validation.
     */
    public function onKernelRequest(\_PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Event\RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        $request = $event->getRequest();
        if ($request::getTrustedProxies()) {
            $request->getClientIps();
        }
        $request->getHost();
    }
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() : array
    {
        return [\_PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\KernelEvents::REQUEST => [['onKernelRequest', 256]]];
    }
}
