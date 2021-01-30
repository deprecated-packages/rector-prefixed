<?php

declare (strict_types=1);
namespace Rector\Core\Reflection;

use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\UseUse;
use Rector\CodingStyle\Naming\ClassNaming;
use Rector\Core\PhpDoc\PhpDocTagsFinder;
use Rector\Core\PhpParser\Parser\FunctionLikeParser;
use ReflectionFunction;
final class FunctionAnnotationResolver
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var FunctionLikeParser
     */
    private $functionLikeParser;
    /**
     * @var PhpDocTagsFinder
     */
    private $phpDocTagsFinder;
    public function __construct(\Rector\CodingStyle\Naming\ClassNaming $classNaming, \Rector\Core\PhpParser\Parser\FunctionLikeParser $functionLikeParser, \Rector\Core\PhpDoc\PhpDocTagsFinder $phpDocTagsFinder)
    {
        $this->functionLikeParser = $functionLikeParser;
        $this->classNaming = $classNaming;
        $this->phpDocTagsFinder = $phpDocTagsFinder;
    }
    /**
     * @return mixed[]
     */
    public function extractFunctionAnnotatedThrows(\ReflectionFunction $reflectionFunction) : array
    {
        $docComment = $reflectionFunction->getDocComment();
        if (!\is_string($docComment)) {
            return [];
        }
        $throwsTypes = $this->phpDocTagsFinder->extractTrowsTypesFromDocBlock($docComment);
        return $this->expandAnnotatedClasses($reflectionFunction, $throwsTypes);
    }
    /**
     * @param mixed[] $classNames
     * @return mixed[]
     */
    private function expandAnnotatedClasses(\ReflectionFunction $reflectionFunction, array $classNames) : array
    {
        $namespace = $this->functionLikeParser->parseFunction($reflectionFunction);
        if (!$namespace instanceof \PhpParser\Node\Stmt\Namespace_) {
            return [];
        }
        $uses = $this->getUses($namespace);
        $expandedClasses = [];
        foreach ($classNames as $className) {
            $shortClassName = $this->classNaming->getShortName($className);
            $expandedClasses[] = $uses[$shortClassName] ?? $className;
        }
        return $expandedClasses;
    }
    /**
     * @return string[]
     */
    private function getUses(\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        $uses = [];
        foreach ($namespace->stmts as $stmt) {
            if (!$stmt instanceof \PhpParser\Node\Stmt\Use_) {
                continue;
            }
            $use = $stmt->uses[0];
            if (!$use instanceof \PhpParser\Node\Stmt\UseUse) {
                continue;
            }
            $parts = $use->name->parts;
            $uses[$parts[\count($parts) - 1]] = \implode('\\', $parts);
        }
        return $uses;
    }
}
