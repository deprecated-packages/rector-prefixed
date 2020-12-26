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

use RectorPrefix2020DecSat\Symfony\Component\HttpFoundation\Request;
use RectorPrefix2020DecSat\Symfony\Component\HttpFoundation\Session\SessionInterface;
use RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use RectorPrefix2020DecSat\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
/**
 * Yields the Session.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
final class SessionValueResolver implements \RectorPrefix2020DecSat\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(\RectorPrefix2020DecSat\Symfony\Component\HttpFoundation\Request $request, \RectorPrefix2020DecSat\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : bool
    {
        if (!$request->hasSession()) {
            return \false;
        }
        $type = $argument->getType();
        if (\RectorPrefix2020DecSat\Symfony\Component\HttpFoundation\Session\SessionInterface::class !== $type && !\is_subclass_of($type, \RectorPrefix2020DecSat\Symfony\Component\HttpFoundation\Session\SessionInterface::class)) {
            return \false;
        }
        return $request->getSession() instanceof $type;
    }
    /**
     * {@inheritdoc}
     */
    public function resolve(\RectorPrefix2020DecSat\Symfony\Component\HttpFoundation\Request $request, \RectorPrefix2020DecSat\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : iterable
    {
        (yield $request->getSession());
    }
}
