<?php

declare (strict_types=1);
namespace Rector\PostRector\NodeAnalyzer;

use PhpParser\Node\Stmt\Class_;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionClass;
use ReflectionMethod;
final class NetteInjectDetector
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isNetteInjectPreferred(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($this->isInjectPropertyAlreadyInTheClass($class)) {
            return \true;
        }
        return $this->hasParentClassConstructor($class);
    }
    private function isInjectPropertyAlreadyInTheClass(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        foreach ($class->getProperties() as $property) {
            if (!$property->isPublic()) {
                continue;
            }
            /** @var PhpDocInfo|null $phpDocInfo */
            $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($phpDocInfo === null) {
                continue;
            }
            $injectPhpDocInfoTagsName = $phpDocInfo->getTagsByName('inject');
            if ($injectPhpDocInfoTagsName === []) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    private function hasParentClassConstructor(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        $className = $this->nodeNameResolver->getName($class);
        if ($className === null) {
            return \false;
        }
        if (!\is_a($className, 'Nette\\Application\\IPresenter', \true)) {
            return \false;
        }
        // has parent class
        if ($class->extends === null) {
            return \false;
        }
        $parentClass = $this->nodeNameResolver->getName($class->extends);
        // is not the nette class - we don't care about that
        if ($parentClass === 'Nette\\Application\\UI\\Presenter') {
            return \false;
        }
        // prefer local constructor
        $classReflection = new \ReflectionClass($className);
        if ($classReflection->hasMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            /** @var ReflectionMethod $constructorReflectionMethod */
            $constructorReflectionMethod = $classReflection->getConstructor();
            // be sure its local constructor
            if ($constructorReflectionMethod->class === $className) {
                return \false;
            }
        }
        $classReflection = new \ReflectionClass($parentClass);
        return $classReflection->hasMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
    }
}
