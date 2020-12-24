<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Reflection;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Parser;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Parser $parser, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->parser = $parser;
        $this->smartFileSystem = $smartFileSystem;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function getClassFromObjectType(\_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $objectType) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_
    {
        $classReflection = $objectType->getClassReflection();
        if ($classReflection === null) {
            return null;
        }
        $className = $objectType->getClassName();
        return $this->getClass($classReflection, $className);
    }
    public function getClass(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $className) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_
    {
        if ($classReflection->isBuiltin()) {
            return null;
        }
        /** @var string $fileName */
        $fileName = $classReflection->getFileName();
        /** @var Node[] $contentNodes */
        $contentNodes = $this->parser->parse($this->smartFileSystem->readFile($fileName));
        $classes = $this->betterNodeFinder->findInstanceOf($contentNodes, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class);
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
