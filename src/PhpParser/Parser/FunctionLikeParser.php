<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Parser;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\NodeFinder;
use PhpParser\Parser;
use PHPStan\Reflection\MethodReflection;
use ReflectionFunction;
use RectorPrefix20210218\Symplify\SmartFileSystem\SmartFileSystem;
final class FunctionLikeParser
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
     * @var NodeFinder
     */
    private $nodeFinder;
    public function __construct(\PhpParser\Parser $parser, \RectorPrefix20210218\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \PhpParser\NodeFinder $nodeFinder)
    {
        $this->parser = $parser;
        $this->smartFileSystem = $smartFileSystem;
        $this->nodeFinder = $nodeFinder;
    }
    public function parseFunction(\ReflectionFunction $reflectionFunction) : ?\PhpParser\Node\Stmt\Namespace_
    {
        $fileName = $reflectionFunction->getFileName();
        if (!\is_string($fileName)) {
            return null;
        }
        $functionCode = $this->smartFileSystem->readFile($fileName);
        if (!\is_string($functionCode)) {
            return null;
        }
        $nodes = (array) $this->parser->parse($functionCode);
        $firstNode = $nodes[0] ?? null;
        if (!$firstNode instanceof \PhpParser\Node\Stmt\Namespace_) {
            return null;
        }
        return $firstNode;
    }
    public function parseMethodReflection(\PHPStan\Reflection\MethodReflection $methodReflection) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        $classReflection = $methodReflection->getDeclaringClass();
        $fileName = $classReflection->getFileName();
        if (!\is_string($fileName)) {
            return null;
        }
        $fileContent = $this->smartFileSystem->readFile($fileName);
        if (!\is_string($fileContent)) {
            return null;
        }
        $nodes = (array) $this->parser->parse($fileContent);
        $class = $this->nodeFinder->findFirstInstanceOf($nodes, \PhpParser\Node\Stmt\Class_::class);
        if (!$class instanceof \PhpParser\Node\Stmt\Class_) {
            return null;
        }
        return $class->getMethod($methodReflection->getName());
    }
}
