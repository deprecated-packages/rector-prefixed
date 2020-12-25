<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Controller\ArgumentResolver;

use _PhpScoperbf340cb0be9d\Symfony\Component\HttpFoundation\Request;
use _PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use _PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
/**
 * Yields a variadic argument's values from the request attributes.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
final class VariadicValueResolver implements \_PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(\_PhpScoperbf340cb0be9d\Symfony\Component\HttpFoundation\Request $request, \_PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : bool
    {
        return $argument->isVariadic() && $request->attributes->has($argument->getName());
    }
    /**
     * {@inheritdoc}
     */
    public function resolve(\_PhpScoperbf340cb0be9d\Symfony\Component\HttpFoundation\Request $request, \_PhpScoperbf340cb0be9d\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : iterable
    {
        $values = $request->attributes->get($argument->getName());
        if (!\is_array($values)) {
            throw new \InvalidArgumentException(\sprintf('The action argument "...$%1$s" is required to be an array, the request attribute "%1$s" contains a type of "%2$s" instead.', $argument->getName(), \get_debug_type($values)));
        }
        yield from $values;
    }
}
