<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210408\Symfony\Component\DependencyInjection\Compiler;

use RectorPrefix20210408\Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Argument\ServiceLocatorArgument;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Container;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Definition;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Exception\InvalidParameterTypeException;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Exception\RuntimeException;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\ExpressionLanguage;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Parameter;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\ParameterBag\EnvPlaceholderParameterBag;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Reference;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\ServiceLocator;
use RectorPrefix20210408\Symfony\Component\ExpressionLanguage\Expression;
/**
 * Checks whether injected parameters are compatible with type declarations.
 *
 * This pass should be run after all optimization passes.
 *
 * It can be added either:
 *  * before removing passes to check all services even if they are not currently used,
 *  * after removing passes to check only services are used in the app.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 * @author Julien Maulny <jmaulny@darkmira.fr>
 */
final class CheckTypeDeclarationsPass extends \RectorPrefix20210408\Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass
{
    private const SCALAR_TYPES = ['int' => \true, 'float' => \true, 'bool' => \true, 'string' => \true];
    private const BUILTIN_TYPES = ['array' => \true, 'bool' => \true, 'callable' => \true, 'float' => \true, 'int' => \true, 'iterable' => \true, 'object' => \true, 'string' => \true];
    private $autoload;
    private $skippedIds;
    private $expressionLanguage;
    /**
     * @param bool  $autoload   Whether services who's class in not loaded should be checked or not.
     *                          Defaults to false to save loading code during compilation.
     * @param array $skippedIds An array indexed by the service ids to skip
     */
    public function __construct(bool $autoload = \false, array $skippedIds = [])
    {
        $this->autoload = $autoload;
        $this->skippedIds = $skippedIds;
    }
    /**
     * {@inheritdoc}
     */
    protected function processValue($value, $isRoot = \false)
    {
        if (isset($this->skippedIds[$this->currentId])) {
            return $value;
        }
        if (!$value instanceof \RectorPrefix20210408\Symfony\Component\DependencyInjection\Definition || $value->hasErrors() || $value->isDeprecated()) {
            return parent::processValue($value, $isRoot);
        }
        if (!$this->autoload && !\class_exists($class = $value->getClass(), \false) && !\interface_exists($class, \false)) {
            return parent::processValue($value, $isRoot);
        }
        if (\RectorPrefix20210408\Symfony\Component\DependencyInjection\ServiceLocator::class === $value->getClass()) {
            return parent::processValue($value, $isRoot);
        }
        if ($constructor = $this->getConstructor($value, \false)) {
            $this->checkTypeDeclarations($value, $constructor, $value->getArguments());
        }
        foreach ($value->getMethodCalls() as $methodCall) {
            try {
                $reflectionMethod = $this->getReflectionMethod($value, $methodCall[0]);
            } catch (\RectorPrefix20210408\Symfony\Component\DependencyInjection\Exception\RuntimeException $e) {
                if ($value->getFactory()) {
                    continue;
                }
                throw $e;
            }
            $this->checkTypeDeclarations($value, $reflectionMethod, $methodCall[1]);
        }
        return parent::processValue($value, $isRoot);
    }
    /**
     * @throws InvalidArgumentException When not enough parameters are defined for the method
     */
    private function checkTypeDeclarations(\RectorPrefix20210408\Symfony\Component\DependencyInjection\Definition $checkedDefinition, \ReflectionFunctionAbstract $reflectionFunction, array $values) : void
    {
        $numberOfRequiredParameters = $reflectionFunction->getNumberOfRequiredParameters();
        if (\count($values) < $numberOfRequiredParameters) {
            throw new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('Invalid definition for service "%s": "%s::%s()" requires %d arguments, %d passed.', $this->currentId, $reflectionFunction->class, $reflectionFunction->name, $numberOfRequiredParameters, \count($values)));
        }
        $reflectionParameters = $reflectionFunction->getParameters();
        $checksCount = \min($reflectionFunction->getNumberOfParameters(), \count($values));
        $envPlaceholderUniquePrefix = $this->container->getParameterBag() instanceof \RectorPrefix20210408\Symfony\Component\DependencyInjection\ParameterBag\EnvPlaceholderParameterBag ? $this->container->getParameterBag()->getEnvPlaceholderUniquePrefix() : null;
        for ($i = 0; $i < $checksCount; ++$i) {
            if (!$reflectionParameters[$i]->hasType() || $reflectionParameters[$i]->isVariadic()) {
                continue;
            }
            $this->checkType($checkedDefinition, $values[$i], $reflectionParameters[$i], $envPlaceholderUniquePrefix);
        }
        if ($reflectionFunction->isVariadic() && ($lastParameter = \end($reflectionParameters))->hasType()) {
            $variadicParameters = \array_slice($values, $lastParameter->getPosition());
            foreach ($variadicParameters as $variadicParameter) {
                $this->checkType($checkedDefinition, $variadicParameter, $lastParameter, $envPlaceholderUniquePrefix);
            }
        }
    }
    /**
     * @throws InvalidParameterTypeException When a parameter is not compatible with the declared type
     */
    private function checkType(\RectorPrefix20210408\Symfony\Component\DependencyInjection\Definition $checkedDefinition, $value, \ReflectionParameter $parameter, ?string $envPlaceholderUniquePrefix, \ReflectionType $reflectionType = null) : void
    {
        $reflectionType = $reflectionType ?? $parameter->getType();
        if ($reflectionType instanceof \ReflectionUnionType) {
            foreach ($reflectionType->getTypes() as $t) {
                try {
                    $this->checkType($checkedDefinition, $value, $parameter, $envPlaceholderUniquePrefix, $t);
                    return;
                } catch (\RectorPrefix20210408\Symfony\Component\DependencyInjection\Exception\InvalidParameterTypeException $e) {
                }
            }
            throw new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Exception\InvalidParameterTypeException($this->currentId, $e->getCode(), $parameter);
        }
        if (!$reflectionType instanceof \ReflectionNamedType) {
            return;
        }
        $type = $reflectionType->getName();
        if ($value instanceof \RectorPrefix20210408\Symfony\Component\DependencyInjection\Reference) {
            if (!$this->container->has($value = (string) $value)) {
                return;
            }
            if ('service_container' === $value && \is_a($type, \RectorPrefix20210408\Symfony\Component\DependencyInjection\Container::class, \true)) {
                return;
            }
            $value = $this->container->findDefinition($value);
        }
        if ('self' === $type) {
            $type = $parameter->getDeclaringClass()->getName();
        }
        if ('static' === $type) {
            $type = $checkedDefinition->getClass();
        }
        $class = null;
        if ($value instanceof \RectorPrefix20210408\Symfony\Component\DependencyInjection\Definition) {
            $class = $value->getClass();
            if (isset(self::BUILTIN_TYPES[\strtolower($class)])) {
                $class = \strtolower($class);
            } elseif (!$class || !$this->autoload && !\class_exists($class, \false) && !\interface_exists($class, \false)) {
                return;
            }
        } elseif ($value instanceof \RectorPrefix20210408\Symfony\Component\DependencyInjection\Parameter) {
            $value = $this->container->getParameter($value);
        } elseif ($value instanceof \RectorPrefix20210408\Symfony\Component\ExpressionLanguage\Expression) {
            try {
                $value = $this->getExpressionLanguage()->evaluate($value, ['container' => $this->container]);
            } catch (\Exception $e) {
                // If a service from the expression cannot be fetched from the container, we skip the validation.
                return;
            }
        } elseif (\is_string($value)) {
            if ('%' === ($value[0] ?? '') && \preg_match('/^%([^%]+)%$/', $value, $match)) {
                $value = $this->container->getParameter(\substr($value, 1, -1));
            }
            if ($envPlaceholderUniquePrefix && \is_string($value) && \false !== \strpos($value, 'env_')) {
                // If the value is an env placeholder that is either mixed with a string or with another env placeholder, then its resolved value will always be a string, so we don't need to resolve it.
                // We don't need to change the value because it is already a string.
                if ('' === \preg_replace('/' . $envPlaceholderUniquePrefix . '_\\w+_[a-f0-9]{32}/U', '', $value, -1, $c) && 1 === $c) {
                    try {
                        $value = $this->container->resolveEnvPlaceholders($value, \true);
                    } catch (\Exception $e) {
                        // If an env placeholder cannot be resolved, we skip the validation.
                        return;
                    }
                }
            }
        }
        if (null === $value && $parameter->allowsNull()) {
            return;
        }
        if (null === $class) {
            if ($value instanceof \RectorPrefix20210408\Symfony\Component\DependencyInjection\Argument\IteratorArgument) {
                $class = \RectorPrefix20210408\Symfony\Component\DependencyInjection\Argument\RewindableGenerator::class;
            } elseif ($value instanceof \RectorPrefix20210408\Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument) {
                $class = \Closure::class;
            } elseif ($value instanceof \RectorPrefix20210408\Symfony\Component\DependencyInjection\Argument\ServiceLocatorArgument) {
                $class = \RectorPrefix20210408\Symfony\Component\DependencyInjection\ServiceLocator::class;
            } elseif (\is_object($value)) {
                $class = \get_class($value);
            } else {
                $class = \gettype($value);
                $class = ['integer' => 'int', 'double' => 'float', 'boolean' => 'bool'][$class] ?? $class;
            }
        }
        if (isset(self::SCALAR_TYPES[$type]) && isset(self::SCALAR_TYPES[$class])) {
            return;
        }
        if ('string' === $type && \method_exists($class, '__toString')) {
            return;
        }
        if ('callable' === $type && (\Closure::class === $class || \method_exists($class, '__invoke'))) {
            return;
        }
        if ('callable' === $type && \is_array($value) && isset($value[0]) && ($value[0] instanceof \RectorPrefix20210408\Symfony\Component\DependencyInjection\Reference || $value[0] instanceof \RectorPrefix20210408\Symfony\Component\DependencyInjection\Definition || \is_string($value[0]))) {
            return;
        }
        if ('iterable' === $type && (\is_array($value) || 'array' === $class || \is_subclass_of($class, \Traversable::class))) {
            return;
        }
        if ($type === $class) {
            return;
        }
        if ('object' === $type && !isset(self::BUILTIN_TYPES[$class])) {
            return;
        }
        if ('mixed' === $type) {
            return;
        }
        if (\is_a($class, $type, \true)) {
            return;
        }
        if ('false' === $type) {
            if (\false === $value) {
                return;
            }
        } elseif ($reflectionType->isBuiltin()) {
            $checkFunction = \sprintf('is_%s', $type);
            if ($checkFunction($value)) {
                return;
            }
        }
        throw new \RectorPrefix20210408\Symfony\Component\DependencyInjection\Exception\InvalidParameterTypeException($this->currentId, \is_object($value) ? $class : \get_debug_type($value), $parameter);
    }
    private function getExpressionLanguage() : \RectorPrefix20210408\Symfony\Component\DependencyInjection\ExpressionLanguage
    {
        if (null === $this->expressionLanguage) {
            $this->expressionLanguage = new \RectorPrefix20210408\Symfony\Component\DependencyInjection\ExpressionLanguage(null, $this->container->getExpressionLanguageProviders());
        }
        return $this->expressionLanguage;
    }
}
