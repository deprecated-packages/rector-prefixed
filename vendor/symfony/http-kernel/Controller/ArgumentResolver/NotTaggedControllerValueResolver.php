<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Controller\ArgumentResolver;

use RectorPrefix2020DecSat\Psr\Container\ContainerInterface;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Exception\RuntimeException;
use RectorPrefix2020DecSat\Symfony\Component\HttpFoundation\Request;
use RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use RectorPrefix2020DecSat\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
/**
 * Provides an intuitive error message when controller fails because it is not registered as a service.
 *
 * @author Simeon Kolev <simeon.kolev9@gmail.com>
 */
final class NotTaggedControllerValueResolver implements \RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface
{
    private $container;
    public function __construct(\RectorPrefix2020DecSat\Psr\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }
    /**
     * {@inheritdoc}
     */
    public function supports(\RectorPrefix2020DecSat\Symfony\Component\HttpFoundation\Request $request, \RectorPrefix2020DecSat\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : bool
    {
        $controller = $request->attributes->get('_controller');
        if (\is_array($controller) && \is_callable($controller, \true) && \is_string($controller[0])) {
            $controller = $controller[0] . '::' . $controller[1];
        } elseif (!\is_string($controller) || '' === $controller) {
            return \false;
        }
        if ('\\' === $controller[0]) {
            $controller = \ltrim($controller, '\\');
        }
        if (!$this->container->has($controller) && \false !== ($i = \strrpos($controller, ':'))) {
            $controller = \substr($controller, 0, $i) . \strtolower(\substr($controller, $i));
        }
        return \false === $this->container->has($controller);
    }
    /**
     * {@inheritdoc}
     */
    public function resolve(\RectorPrefix2020DecSat\Symfony\Component\HttpFoundation\Request $request, \RectorPrefix2020DecSat\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : iterable
    {
        if (\is_array($controller = $request->attributes->get('_controller'))) {
            $controller = $controller[0] . '::' . $controller[1];
        }
        if ('\\' === $controller[0]) {
            $controller = \ltrim($controller, '\\');
        }
        if (!$this->container->has($controller)) {
            $i = \strrpos($controller, ':');
            $controller = \substr($controller, 0, $i) . \strtolower(\substr($controller, $i));
        }
        $what = \sprintf('argument $%s of "%s()"', $argument->getName(), $controller);
        $message = \sprintf('Could not resolve %s, maybe you forgot to register the controller as a service or missed tagging it with the "controller.service_arguments"?', $what);
        throw new \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Exception\RuntimeException($message);
    }
}
