<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\GlobalConstantReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionWithFilename;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
class ClassBlacklistReflectionProvider implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    /** @var PhpStormStubsSourceStubber */
    private $phpStormStubsSourceStubber;
    /** @var string[] */
    private $patterns;
    /** @var string|null */
    private $singleReflectionFile;
    /**
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param string[] $patterns
     */
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpStormStubsSourceStubber, array $patterns, ?string $singleReflectionFile)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->phpStormStubsSourceStubber = $phpStormStubsSourceStubber;
        $this->patterns = $patterns;
        $this->singleReflectionFile = $singleReflectionFile;
    }
    public function hasClass(string $className) : bool
    {
        if ($this->isClassBlacklisted($className)) {
            return \false;
        }
        $has = $this->reflectionProvider->hasClass($className);
        if (!$has) {
            return \false;
        }
        $classReflection = $this->reflectionProvider->getClass($className);
        if ($this->singleReflectionFile !== null) {
            if ($classReflection->getFileName() === $this->singleReflectionFile) {
                return \false;
            }
        }
        foreach ($classReflection->getParentClassesNames() as $parentClassName) {
            if ($this->isClassBlacklisted($parentClassName)) {
                return \false;
            }
        }
        foreach ($classReflection->getNativeReflection()->getInterfaceNames() as $interfaceName) {
            if ($this->isClassBlacklisted($interfaceName)) {
                return \false;
            }
        }
        return \true;
    }
    private function isClassBlacklisted(string $className) : bool
    {
        if ($this->phpStormStubsSourceStubber->hasClass($className)) {
            // check that userland class isn't aliased to the same name as a class from stubs
            if (!\class_exists($className, \false)) {
                return \true;
            }
            if (\in_array(\strtolower($className), ['reflectionuniontype', 'attribute'], \true)) {
                return \true;
            }
            $reflection = new \ReflectionClass($className);
            if ($reflection->getFileName() === \false) {
                return \true;
            }
        }
        foreach ($this->patterns as $pattern) {
            if (\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match($className, $pattern) !== null) {
                return \true;
            }
        }
        return \false;
    }
    public function getClass(string $className) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
    {
        if (!$this->hasClass($className)) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\Broker\ClassNotFoundException($className);
        }
        return $this->reflectionProvider->getClass($className);
    }
    public function getClassName(string $className) : string
    {
        if (!$this->hasClass($className)) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\Broker\ClassNotFoundException($className);
        }
        return $this->reflectionProvider->getClassName($className);
    }
    public function supportsAnonymousClasses() : bool
    {
        return \false;
    }
    public function getAnonymousClassReflection(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $classNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
    {
        throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
    }
    public function hasFunction(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : bool
    {
        $has = $this->reflectionProvider->hasFunction($nameNode, $scope);
        if (!$has) {
            return \false;
        }
        if ($this->singleReflectionFile === null) {
            return \true;
        }
        $functionReflection = $this->reflectionProvider->getFunction($nameNode, $scope);
        if (!$functionReflection instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionWithFilename) {
            return \true;
        }
        return $functionReflection->getFileName() !== $this->singleReflectionFile;
    }
    public function getFunction(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection
    {
        return $this->reflectionProvider->getFunction($nameNode, $scope);
    }
    public function resolveFunctionName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->reflectionProvider->resolveFunctionName($nameNode, $scope);
    }
    public function hasConstant(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->reflectionProvider->hasConstant($nameNode, $scope);
    }
    public function getConstant(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\GlobalConstantReflection
    {
        return $this->reflectionProvider->getConstant($nameNode, $scope);
    }
    public function resolveConstantName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $nameNode, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->reflectionProvider->resolveConstantName($nameNode, $scope);
    }
}
