<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210408\Symfony\Component\HttpKernel\Event;

use RectorPrefix20210408\Symfony\Component\HttpFoundation\Request;
use RectorPrefix20210408\Symfony\Component\HttpKernel\HttpKernelInterface;
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
final class ControllerArgumentsEvent extends \RectorPrefix20210408\Symfony\Component\HttpKernel\Event\KernelEvent
{
    private $controller;
    private $arguments;
    public function __construct(\RectorPrefix20210408\Symfony\Component\HttpKernel\HttpKernelInterface $kernel, callable $controller, array $arguments, \RectorPrefix20210408\Symfony\Component\HttpFoundation\Request $request, ?int $requestType)
    {
        parent::__construct($kernel, $request, $requestType);
        $this->controller = $controller;
        $this->arguments = $arguments;
    }
    public function getController() : callable
    {
        return $this->controller;
    }
    public function setController(callable $controller)
    {
        $this->controller = $controller;
    }
    public function getArguments() : array
    {
        return $this->arguments;
    }
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }
}
