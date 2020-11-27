<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper88fe6e0ad041\Symfony\Contracts\EventDispatcher;

use _PhpScoper88fe6e0ad041\Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;
if (\interface_exists(\_PhpScoper88fe6e0ad041\Psr\EventDispatcher\EventDispatcherInterface::class)) {
    /**
     * Allows providing hooks on domain-specific lifecycles by dispatching events.
     */
    interface EventDispatcherInterface extends \_PhpScoper88fe6e0ad041\Psr\EventDispatcher\EventDispatcherInterface
    {
        /**
         * Dispatches an event to all registered listeners.
         *
         * For BC with Symfony 4, the $eventName argument is not declared explicitly on the
         * signature of the method. Implementations that are not bound by this BC constraint
         * MUST declare it explicitly, as allowed by PHP.
         *
         * @param object      $event     The event to pass to the event handlers/listeners
         * @param string|null $eventName The name of the event to dispatch. If not supplied,
         *                               the class of $event should be used instead.
         *
         * @return object The passed $event MUST be returned
         */
        public function dispatch($event);
    }
} else {
    /**
     * Allows providing hooks on domain-specific lifecycles by dispatching events.
     */
    interface EventDispatcherInterface
    {
        /**
         * Dispatches an event to all registered listeners.
         *
         * For BC with Symfony 4, the $eventName argument is not declared explicitly on the
         * signature of the method. Implementations that are not bound by this BC constraint
         * MUST declare it explicitly, as allowed by PHP.
         *
         * @param object      $event     The event to pass to the event handlers/listeners
         * @param string|null $eventName The name of the event to dispatch. If not supplied,
         *                               the class of $event should be used instead.
         *
         * @return object The passed $event MUST be returned
         */
        public function dispatch($event);
    }
}
