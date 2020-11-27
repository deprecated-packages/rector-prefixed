<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\Event;

use _PhpScoperbd5d0c5f7638\Symfony\Component\HttpFoundation\Request;
use _PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\HttpKernelInterface;
/**
 * @deprecated since Symfony 4.3, use ViewEvent instead
 */
class GetResponseForControllerResultEvent extends \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\Event\RequestEvent
{
    /**
     * The return value of the controller.
     *
     * @var mixed
     */
    private $controllerResult;
    public function __construct(\_PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\HttpKernelInterface $kernel, \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpFoundation\Request $request, int $requestType, $controllerResult)
    {
        parent::__construct($kernel, $request, $requestType);
        $this->controllerResult = $controllerResult;
    }
    /**
     * Returns the return value of the controller.
     *
     * @return mixed The controller return value
     */
    public function getControllerResult()
    {
        return $this->controllerResult;
    }
    /**
     * Assigns the return value of the controller.
     *
     * @param mixed $controllerResult The controller return value
     */
    public function setControllerResult($controllerResult)
    {
        $this->controllerResult = $controllerResult;
    }
}
