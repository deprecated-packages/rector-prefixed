<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210317\Symfony\Component\HttpKernel\EventListener;

use RectorPrefix20210317\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use RectorPrefix20210317\Symfony\Component\HttpKernel\Event\RequestEvent;
use RectorPrefix20210317\Symfony\Component\HttpKernel\KernelEvents;
/**
 * Adds configured formats to each request.
 *
 * @author Gildas Quemener <gildas.quemener@gmail.com>
 *
 * @final
 */
class AddRequestFormatsListener implements \RectorPrefix20210317\Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    protected $formats;
    /**
     * @param mixed[] $formats
     */
    public function __construct($formats)
    {
        $this->formats = $formats;
    }
    /**
     * Adds request formats.
     * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
     */
    public function onKernelRequest($event)
    {
        $request = $event->getRequest();
        foreach ($this->formats as $format => $mimeTypes) {
            $request->setFormat($format, $mimeTypes);
        }
    }
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() : array
    {
        return [\RectorPrefix20210317\Symfony\Component\HttpKernel\KernelEvents::REQUEST => ['onKernelRequest', 100]];
    }
}
