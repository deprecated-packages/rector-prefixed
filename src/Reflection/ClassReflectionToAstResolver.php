<?php

declare (strict_types=1);
namespace Rector\Core\Reflection;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Parser;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ObjectType;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use RectorPrefix20210415\Symplify\SmartFileSystem\SmartFileSystem;
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
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\PhpParser\Parser $parser, \RectorPrefix20210415\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->parser = $parser;
        $this->smartFileSystem = $smartFileSystem;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getClassFromObjectType(\PHPStan\Type\ObjectType $objectType) : ?\PhpParser\Node\Stmt\Class_
    {
        if (!$this->reflectionProvider->hasClass($objectType->getClassName())) {
            return null;
        }
        $classReflection = $this->reflectionProvider->getClass($objectType->getClassName());
        return $this->getClass($classReflection, $objectType->getClassName());
    }
    private function getClass(\PHPStan\Reflection\ClassReflection $classReflection, string $className) : ?\PhpParser\Node\Stmt\Class_
    {
        if ($classReflection->isBuiltin()) {
            return null;
        }
        /** @var string $fileName */
        $fileName = $classReflection->getFileName();
        /** @var Node[] $contentNodes */
        $contentNodes = $this->parser->parse($this->smartFileSystem->readFile($fileName));
        /** @var Class_[] $classes */
        $classes = $this->betterNodeFinder->findInstanceOf($contentNodes, \PhpParser\Node\Stmt\Class_::class);
        if ($classes === []) {
            return null;
        }
        $reflectionClassName = $classReflection->getName();
        foreach ($classes as $class) {
            if ($reflectionClassName === $className) {
                return $class;
            }
        }
        return null;
    }
}
