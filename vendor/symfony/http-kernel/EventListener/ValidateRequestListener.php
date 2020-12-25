<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper17db12703726\Symfony\Component\HttpKernel\EventListener;

use _PhpScoper17db12703726\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use _PhpScoper17db12703726\Symfony\Component\HttpKernel\Event\RequestEvent;
use _PhpScoper17db12703726\Symfony\Component\HttpKernel\KernelEvents;
/**
 * Validates Requests.
 *
 * @author Magnus Nordlander <magnus@fervo.se>
 *
 * @final
 */
class ValidateRequestListener implements \_PhpScoper17db12703726\Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    /**
     * Performs the validation.
     */
    public function onKernelRequest(\_PhpScoper17db12703726\Symfony\Component\HttpKernel\Event\RequestEvent $event)
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
        return [\_PhpScoper17db12703726\Symfony\Component\HttpKernel\KernelEvents::REQUEST => [['onKernelRequest', 256]]];
    }
}
