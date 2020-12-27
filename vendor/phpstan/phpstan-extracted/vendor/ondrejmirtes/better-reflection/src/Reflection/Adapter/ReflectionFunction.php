<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter;

use Exception;
use ReflectionException as CoreReflectionException;
use ReflectionFunction as CoreReflectionFunction;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\Exception\NotImplemented;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction as BetterReflectionFunction;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\FileHelper;
use Throwable;
use function func_get_args;
class ReflectionFunction extends \ReflectionFunction
{
    /** @var BetterReflectionFunction */
    private $betterReflectionFunction;
    public function __construct(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction $betterReflectionFunction)
    {
        $this->betterReflectionFunction = $betterReflectionFunction;
    }
    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    public static function export($name, $return = null)
    {
        throw new \Exception('Unable to export statically');
    }
    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->betterReflectionFunction->__toString();
    }
    /**
     * {@inheritDoc}
     */
    public function inNamespace()
    {
        return $this->betterReflectionFunction->inNamespace();
    }
    /**
     * {@inheritDoc}
     */
    public function isClosure()
    {
        return $this->betterReflectionFunction->isClosure();
    }
    /**
     * {@inheritDoc}
     */
    public function isDeprecated()
    {
        return $this->betterReflectionFunction->isDeprecated();
    }
    /**
     * {@inheritDoc}
     */
    public function isInternal()
    {
        return $this->betterReflectionFunction->isInternal();
    }
    /**
     * {@inheritDoc}
     */
    public function isUserDefined()
    {
        return $this->betterReflectionFunction->isUserDefined();
    }
    /**
     * {@inheritDoc}
     */
    public function getClosureThis()
    {
        throw new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\Exception\NotImplemented('Not implemented');
    }
    /**
     * {@inheritDoc}
     */
    public function getClosureScopeClass()
    {
        throw new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\Exception\NotImplemented('Not implemented');
    }
    /**
     * {@inheritDoc}
     */
    public function getDocComment()
    {
        return $this->betterReflectionFunction->getDocComment() ?: \false;
    }
    /**
     * {@inheritDoc}
     */
    public function getEndLine()
    {
        return $this->betterReflectionFunction->getEndLine();
    }
    /**
     * {@inheritDoc}
     */
    public function getExtension()
    {
        throw new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\Exception\NotImplemented('Not implemented');
    }
    /**
     * {@inheritDoc}
     */
    public function getExtensionName()
    {
        return $this->betterReflectionFunction->getExtensionName() ?? \false;
    }
    /**
     * {@inheritDoc}
     */
    public function getFileName()
    {
        $fileName = $this->betterReflectionFunction->getFileName();
        return $fileName !== null ? \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\FileHelper::normalizeSystemPath($fileName) : \false;
    }
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->betterReflectionFunction->getName();
    }
    /**
     * {@inheritDoc}
     */
    public function getNamespaceName()
    {
        return $this->betterReflectionFunction->getNamespaceName();
    }
    /**
     * {@inheritDoc}
     */
    public function getNumberOfParameters()
    {
        return $this->betterReflectionFunction->getNumberOfParameters();
    }
    /**
     * {@inheritDoc}
     */
    public function getNumberOfRequiredParameters()
    {
        return $this->betterReflectionFunction->getNumberOfRequiredParameters();
    }
    /**
     * {@inheritDoc}
     */
    public function getParameters()
    {
        $parameters = $this->betterReflectionFunction->getParameters();
        $wrappedParameters = [];
        foreach ($parameters as $key => $parameter) {
            $wrappedParameters[$key] = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionParameter($parameter);
        }
        return $wrappedParameters;
    }
    /**
     * {@inheritDoc}
     */
    public function getReturnType()
    {
        return \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionType::fromReturnTypeOrNull($this->betterReflectionFunction->getReturnType());
    }
    /**
     * {@inheritDoc}
     */
    public function getShortName()
    {
        return $this->betterReflectionFunction->getShortName();
    }
    /**
     * {@inheritDoc}
     */
    public function getStartLine()
    {
        return $this->betterReflectionFunction->getStartLine();
    }
    /**
     * {@inheritDoc}
     */
    public function getStaticVariables()
    {
        throw new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\Exception\NotImplemented('Not implemented');
    }
    /**
     * {@inheritDoc}
     */
    public function returnsReference()
    {
        return $this->betterReflectionFunction->returnsReference();
    }
    /**
     * {@inheritDoc}
     */
    public function isGenerator()
    {
        return $this->betterReflectionFunction->isGenerator();
    }
    /**
     * {@inheritDoc}
     */
    public function isVariadic()
    {
        return $this->betterReflectionFunction->isVariadic();
    }
    /**
     * {@inheritDoc}
     */
    public function isDisabled()
    {
        return $this->betterReflectionFunction->isDisabled();
    }
    /**
     * {@inheritDoc}
     */
    public function invoke($arg = null, ...$args)
    {
        try {
            return $this->betterReflectionFunction->invoke(...\func_get_args());
        } catch (\Throwable $e) {
            throw new \ReflectionException($e->getMessage(), 0, $e);
        }
    }
    /**
     * {@inheritDoc}
     */
    public function invokeArgs(array $args)
    {
        try {
            return $this->betterReflectionFunction->invokeArgs($args);
        } catch (\Throwable $e) {
            throw new \ReflectionException($e->getMessage(), 0, $e);
        }
    }
    /**
     * {@inheritDoc}
     */
    public function getClosure()
    {
        try {
            return $this->betterReflectionFunction->getClosure();
        } catch (\Throwable $e) {
            return null;
        }
    }
}
