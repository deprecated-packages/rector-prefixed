<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Reflection;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\UseUse;
use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpDoc\PhpDocTagsFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Parser\FunctionParser;
use ReflectionFunction;
final class FunctionAnnotationResolver
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var FunctionParser
     */
    private $functionParser;
    /**
     * @var PhpDocTagsFinder
     */
    private $phpDocTagsFinder;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Parser\FunctionParser $functionParser, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpDoc\PhpDocTagsFinder $phpDocTagsFinder)
    {
        $this->functionParser = $functionParser;
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
        $namespace = $this->functionParser->parseFunction($reflectionFunction);
        if (!$namespace instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_) {
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
    private function getUses(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        $uses = [];
        foreach ($namespace->stmts as $stmt) {
            if (!$stmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_) {
                continue;
            }
            $use = $stmt->uses[0];
            if (!$use instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\UseUse) {
                continue;
            }
            $parts = $use->name->parts;
            $uses[$parts[\count($parts) - 1]] = \implode('\\', $parts);
        }
        return $uses;
    }
}
