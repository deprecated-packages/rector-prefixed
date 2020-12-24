<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopere8e811afab72\Symfony\Component\HttpKernel\EventListener;

use _PhpScopere8e811afab72\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\Event\ResponseEvent;
use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\HttpCache\HttpCache;
use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\HttpCache\SurrogateInterface;
use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\KernelEvents;
/**
 * SurrogateListener adds a Surrogate-Control HTTP header when the Response needs to be parsed for Surrogates.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @final
 */
class SurrogateListener implements \_PhpScopere8e811afab72\Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    private $surrogate;
    public function __construct(\_PhpScopere8e811afab72\Symfony\Component\HttpKernel\HttpCache\SurrogateInterface $surrogate = null)
    {
        $this->surrogate = $surrogate;
    }
    /**
     * Filters the Response.
     */
    public function onKernelResponse(\_PhpScopere8e811afab72\Symfony\Component\HttpKernel\Event\ResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        $kernel = $event->getKernel();
        $surrogate = $this->surrogate;
        if ($kernel instanceof \_PhpScopere8e811afab72\Symfony\Component\HttpKernel\HttpCache\HttpCache) {
            $surrogate = $kernel->getSurrogate();
            if (null !== $this->surrogate && $this->surrogate->getName() !== $surrogate->getName()) {
                $surrogate = $this->surrogate;
            }
        }
        if (null === $surrogate) {
            return;
        }
        $surrogate->addSurrogateControl($event->getResponse());
    }
    public static function getSubscribedEvents() : array
    {
        return [\_PhpScopere8e811afab72\Symfony\Component\HttpKernel\KernelEvents::RESPONSE => 'onKernelResponse'];
    }
}
