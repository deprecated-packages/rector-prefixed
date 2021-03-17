<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210317\Symfony\Component\HttpKernel\Event;

use RectorPrefix20210317\Symfony\Component\HttpFoundation\Request;
use RectorPrefix20210317\Symfony\Component\HttpKernel\HttpKernelInterface;
/**
 * Allows filtering of controller arguments.
 *
 * You can call getController() to retrieve the controller and getArguments
 * to retrieve the current arguments. With setArguments() you can replace
 * arguments that are used to call the controller.
 *
 * Arguments set in the event must be compatible with the signature of the
 * controller.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
final class ControllerArgumentsEvent extends \RectorPrefix20210317\Symfony\Component\HttpKernel\Event\KernelEvent
{
    private $controller;
    private $arguments;
    /**
     * @param \Symfony\Component\HttpKernel\HttpKernelInterface $kernel
     * @param callable $controller
     * @param mixed[] $arguments
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int|null $requestType
     */
    public function __construct($kernel, $controller, $arguments, $request, $requestType)
    {
        parent::__construct($kernel, $request, $requestType);
        $this->controller = $controller;
        $this->arguments = $arguments;
    }
    public function getController() : callable
    {
        return $this->controller;
    }
    /**
     * @param callable $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }
    public function getArguments() : array
    {
        return $this->arguments;
    }
    /**
     * @param mixed[] $arguments
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }
}
