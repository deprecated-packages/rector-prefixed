<?php

declare (strict_types=1);
namespace Rector\Core\Reflection;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Parser;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Type\ObjectType;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use RectorPrefix20210104\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\PhpParser\Parser $parser, \RectorPrefix20210104\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->parser = $parser;
        $this->smartFileSystem = $smartFileSystem;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function getClassFromObjectType(\PHPStan\Type\ObjectType $objectType) : ?\PhpParser\Node\Stmt\Class_
    {
        $classReflection = $objectType->getClassReflection();
        if ($classReflection === null) {
            return null;
        }
        $className = $objectType->getClassName();
        return $this->getClass($classReflection, $className);
    }
    public function getClass(\PHPStan\Reflection\ClassReflection $classReflection, string $className) : ?\PhpParser\Node\Stmt\Class_
    {
        if ($classReflection->isBuiltin()) {
            return null;
        }
        /** @var string $fileName */
        $fileName = $classReflection->getFileName();
        /** @var Node[] $contentNodes */
        $contentNodes = $this->parser->parse($this->smartFileSystem->readFile($fileName));
        $classes = $this->betterNodeFinder->findInstanceOf($contentNodes, \PhpParser\Node\Stmt\Class_::class);
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
