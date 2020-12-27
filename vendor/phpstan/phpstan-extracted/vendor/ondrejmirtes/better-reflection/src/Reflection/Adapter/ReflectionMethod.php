<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter;

use Exception;
use ReflectionException as CoreReflectionException;
use ReflectionMethod as CoreReflectionMethod;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\Exception\NotImplemented;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NoObjectProvided;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnObject;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionMethod as BetterReflectionMethod;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\FileHelper;
use Throwable;
use function func_get_args;
class ReflectionMethod extends \ReflectionMethod
{
    /** @var BetterReflectionMethod */
    private $betterReflectionMethod;
    /** @var bool */
    private $accessible = \false;
    public function __construct(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionMethod $betterReflectionMethod)
    {
        $this->betterReflectionMethod = $betterReflectionMethod;
    }
    public function getBetterReflection() : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionMethod
    {
        return $this->betterReflectionMethod;
    }
    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    public static function export($class, $name, $return = null)
    {
        throw new \Exception('Unable to export statically');
    }
    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->betterReflectionMethod->__toString();
    }
    /**
     * {@inheritDoc}
     */
    public function inNamespace()
    {
        return $this->betterReflectionMethod->inNamespace();
    }
    /**
     * {@inheritDoc}
     */
    public function isClosure()
    {
        return $this->betterReflectionMethod->isClosure();
    }
    /**
     * {@inheritDoc}
     */
    public function isDeprecated()
    {
        return $this->betterReflectionMethod->isDeprecated();
    }
    /**
     * {@inheritDoc}
     */
    public function isInternal()
    {
        return $this->betterReflectionMethod->isInternal();
    }
    /**
     * {@inheritDoc}
     */
    public function isUserDefined()
    {
        return $this->betterReflectionMethod->isUserDefined();
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
        return $this->betterReflectionMethod->getDocComment() ?: \false;
    }
    /**
     * {@inheritDoc}
     */
    public function getEndLine()
    {
        return $this->betterReflectionMethod->getEndLine();
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
        return $this->betterReflectionMethod->getExtensionName() ?? \false;
    }
    /**
     * {@inheritDoc}
     */
    public function getFileName()
    {
        $fileName = $this->betterReflectionMethod->getFileName();
        return $fileName !== null ? \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\FileHelper::normalizeSystemPath($fileName) : \false;
    }
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->betterReflectionMethod->getName();
    }
    /**
     * {@inheritDoc}
     */
    public function getNamespaceName()
    {
        return $this->betterReflectionMethod->getNamespaceName();
    }
    /**
     * {@inheritDoc}
     */
    public function getNumberOfParameters()
    {
        return $this->betterReflectionMethod->getNumberOfParameters();
    }
    /**
     * {@inheritDoc}
     */
    public function getNumberOfRequiredParameters()
    {
        return $this->betterReflectionMethod->getNumberOfRequiredParameters();
    }
    /**
     * {@inheritDoc}
     */
    public function getParameters()
    {
        $parameters = $this->betterReflectionMethod->getParameters();
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
        return \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionType::fromReturnTypeOrNull($this->betterReflectionMethod->getReturnType());
    }
    /**
     * {@inheritDoc}
     */
    public function getShortName()
    {
        return $this->betterReflectionMethod->getShortName();
    }
    /**
     * {@inheritDoc}
     */
    public function getStartLine()
    {
        return $this->betterReflectionMethod->getStartLine();
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
        return $this->betterReflectionMethod->returnsReference();
    }
    /**
     * {@inheritDoc}
     */
    public function isGenerator()
    {
        return $this->betterReflectionMethod->isGenerator();
    }
    /**
     * {@inheritDoc}
     */
    public function isVariadic()
    {
        return $this->betterReflectionMethod->isVariadic();
    }
    /**
     * {@inheritDoc}
     */
    public function isPublic()
    {
        return $this->betterReflectionMethod->isPublic();
    }
    /**
     * {@inheritDoc}
     */
    public function isPrivate()
    {
        return $this->betterReflectionMethod->isPrivate();
    }
    /**
     * {@inheritDoc}
     */
    public function isProtected()
    {
        return $this->betterReflectionMethod->isProtected();
    }
    /**
     * {@inheritDoc}
     */
    public function isAbstract()
    {
        return $this->betterReflectionMethod->isAbstract();
    }
    /**
     * {@inheritDoc}
     */
    public function isFinal()
    {
        return $this->betterReflectionMethod->isFinal();
    }
    /**
     * {@inheritDoc}
     */
    public function isStatic()
    {
        return $this->betterReflectionMethod->isStatic();
    }
    /**
     * {@inheritDoc}
     */
    public function isConstructor()
    {
        return $this->betterReflectionMethod->isConstructor();
    }
    /**
     * {@inheritDoc}
     */
    public function isDestructor()
    {
        return $this->betterReflectionMethod->isDestructor();
    }
    /**
     * {@inheritDoc}
     */
    public function getClosure($object = null)
    {
        try {
            return $this->betterReflectionMethod->getClosure($object);
        } catch (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NoObjectProvided|\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnObject $e) {
            return null;
        } catch (\Throwable $e) {
            throw new \ReflectionException($e->getMessage(), 0, $e);
        }
    }
    /**
     * {@inheritDoc}
     */
    public function getModifiers()
    {
        return $this->betterReflectionMethod->getModifiers();
    }
    /**
     * {@inheritDoc}
     */
    public function invoke($object = null, $arg = null, ...$args)
    {
        if (!$this->isAccessible()) {
            throw new \ReflectionException('Method not accessible');
        }
        try {
            return $this->betterReflectionMethod->invoke(...\func_get_args());
        } catch (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NoObjectProvided|\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnObject $e) {
            return null;
        } catch (\Throwable $e) {
            throw new \ReflectionException($e->getMessage(), 0, $e);
        }
    }
    /**
     * {@inheritDoc}
     */
    public function invokeArgs($object = null, array $args = [])
    {
        if (!$this->isAccessible()) {
            throw new \ReflectionException('Method not accessible');
        }
        try {
            return $this->betterReflectionMethod->invokeArgs($object, $args);
        } catch (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NoObjectProvided|\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnObject $e) {
            return null;
        } catch (\Throwable $e) {
            throw new \ReflectionException($e->getMessage(), 0, $e);
        }
    }
    /**
     * {@inheritDoc}
     */
    public function getDeclaringClass()
    {
        return new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\ReflectionClass($this->betterReflectionMethod->getImplementingClass());
    }
    /**
     * {@inheritDoc}
     */
    public function getPrototype()
    {
        return new self($this->betterReflectionMethod->getPrototype());
    }
    /**
     * {@inheritDoc}
     */
    public function setAccessible($accessible)
    {
        $this->accessible = \true;
    }
    private function isAccessible() : bool
    {
        return $this->accessible || $this->isPublic();
    }
}
