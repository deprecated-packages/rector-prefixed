<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Reflection;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpDoc\PhpDocTagsFinder;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Parser\FunctionParser;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Parser\FunctionParser $functionParser, \_PhpScoper0a2ac50786fa\Rector\Core\PhpDoc\PhpDocTagsFinder $phpDocTagsFinder)
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
        if (!$namespace instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_) {
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
    private function getUses(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        $uses = [];
        foreach ($namespace->stmts as $stmt) {
            if (!$stmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_) {
                continue;
            }
            $use = $stmt->uses[0];
            if (!$use instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse) {
                continue;
            }
            $parts = $use->name->parts;
            $uses[$parts[\count($parts) - 1]] = \implode('\\', $parts);
        }
        return $uses;
    }
}
