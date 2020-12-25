<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload;

use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod\LoaderMethodInterface;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\Exception\ClassAlreadyLoaded;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\Exception\ClassAlreadyRegistered;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\Exception\FailedToLoadClass;
use function array_key_exists;
use function class_exists;
use function interface_exists;
use function spl_autoload_register;
use function trait_exists;
final class ClassLoader
{
    /** @var ReflectionClass[] */
    private $reflections = [];
    /** @var LoaderMethodInterface */
    private $loaderMethod;
    public function __construct(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod\LoaderMethodInterface $loaderMethod)
    {
        $this->loaderMethod = $loaderMethod;
        \spl_autoload_register($this, \true, \true);
    }
    /**
     * @throws ClassAlreadyLoaded
     * @throws ClassAlreadyRegistered
     */
    public function addClass(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $reflectionClass) : void
    {
        if (\array_key_exists($reflectionClass->getName(), $this->reflections)) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\Exception\ClassAlreadyRegistered::fromReflectionClass($reflectionClass);
        }
        if (\class_exists($reflectionClass->getName(), \false)) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\Exception\ClassAlreadyLoaded::fromReflectionClass($reflectionClass);
        }
        $this->reflections[$reflectionClass->getName()] = $reflectionClass;
    }
    /**
     * @throws FailedToLoadClass
     */
    public function __invoke(string $classToLoad) : bool
    {
        if (!\array_key_exists($classToLoad, $this->reflections)) {
            return \false;
        }
        $this->loaderMethod->__invoke($this->reflections[$classToLoad]);
        if (!(\class_exists($classToLoad, \false) || \interface_exists($classToLoad, \false) || \trait_exists($classToLoad, \false))) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\Exception\FailedToLoadClass::fromClassName($classToLoad);
        }
        return \true;
    }
}
