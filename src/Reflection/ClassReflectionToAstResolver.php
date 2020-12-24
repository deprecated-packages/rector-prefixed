<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Reflection;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Parser;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
final class ClassReflectionToAstResolver
{
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Parser $parser, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->parser = $parser;
        $this->smartFileSystem = $smartFileSystem;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function getClassFromObjectType(\_PhpScopere8e811afab72\PHPStan\Type\ObjectType $objectType) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        $classReflection = $objectType->getClassReflection();
        if ($classReflection === null) {
            return null;
        }
        $className = $objectType->getClassName();
        return $this->getClass($classReflection, $className);
    }
    public function getClass(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $className) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        if ($classReflection->isBuiltin()) {
            return null;
        }
        /** @var string $fileName */
        $fileName = $classReflection->getFileName();
        /** @var Node[] $contentNodes */
        $contentNodes = $this->parser->parse($this->smartFileSystem->readFile($fileName));
        $classes = $this->betterNodeFinder->findInstanceOf($contentNodes, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class);
        if ($classes === []) {
            return null;
        }
        $reflectionClassName = $classReflection->getName();
        foreach ($classes as $class) {
            $shortClassName = $class->name;
            if ($reflectionClassName === $className) {
                return $class;
            }
        }
        return null;
    }
}
