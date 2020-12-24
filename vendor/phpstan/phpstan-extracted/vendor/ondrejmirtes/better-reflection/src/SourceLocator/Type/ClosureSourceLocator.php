<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type;

use Closure;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract;
use _PhpScopere8e811afab72\PhpParser\Parser;
use ReflectionFunction as CoreFunctionReflection;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Exception\ParseToAstFailure;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception\EvaledClosureCannotBeLocated;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception\TwoClosuresOnSameLine;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\FileChecker;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\FileHelper;
use function array_filter;
use function array_values;
use function assert;
use function file_get_contents;
use function is_array;
use function strpos;
/**
 * @internal
 */
final class ClosureSourceLocator implements \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var CoreFunctionReflection */
    private $coreFunctionReflection;
    /** @var Parser */
    private $parser;
    public function __construct(\Closure $closure, \_PhpScopere8e811afab72\PhpParser\Parser $parser)
    {
        $this->coreFunctionReflection = new \ReflectionFunction($closure);
        $this->parser = $parser;
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public function locateIdentifier(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        return $this->getReflectionFunction($reflector, $identifier->getType());
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public function locateIdentifiersByType(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return \array_filter([$this->getReflectionFunction($reflector, $identifierType)]);
    }
    private function getReflectionFunction(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : ?\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction
    {
        if (!$identifierType->isFunction()) {
            return null;
        }
        $fileName = $this->coreFunctionReflection->getFileName();
        if (\strpos($fileName, 'eval()\'d code') !== \false) {
            throw \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception\EvaledClosureCannotBeLocated::create();
        }
        \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\FileChecker::assertReadableFile($fileName);
        $fileName = \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\FileHelper::normalizeWindowsPath($fileName);
        $nodeVisitor = new class($fileName, $this->coreFunctionReflection->getStartLine()) extends \_PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract
        {
            /** @var string */
            private $fileName;
            /** @var int */
            private $startLine;
            /** @var (Node|null)[][] */
            private $closureNodes = [];
            /** @var Namespace_|null */
            private $currentNamespace;
            public function __construct(string $fileName, int $startLine)
            {
                $this->fileName = $fileName;
                $this->startLine = $startLine;
            }
            /**
             * {@inheritDoc}
             */
            public function enterNode(\_PhpScopere8e811afab72\PhpParser\Node $node)
            {
                if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_) {
                    $this->currentNamespace = $node;
                    return null;
                }
                if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure) {
                    return null;
                }
                $this->closureNodes[] = [$node, $this->currentNamespace];
                return null;
            }
            /**
             * {@inheritDoc}
             */
            public function leaveNode(\_PhpScopere8e811afab72\PhpParser\Node $node)
            {
                if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_) {
                    return null;
                }
                $this->currentNamespace = null;
                return null;
            }
            /**
             * @return Node[]|null[]|null
             *
             * @throws TwoClosuresOnSameLine
             */
            public function getClosureNodes() : ?array
            {
                /** @var (Node|null)[][] $closureNodesDataOnSameLine */
                $closureNodesDataOnSameLine = \array_values(\array_filter($this->closureNodes, function (array $nodes) : bool {
                    return $nodes[0]->getLine() === $this->startLine;
                }));
                if (!$closureNodesDataOnSameLine) {
                    return null;
                }
                if (isset($closureNodesDataOnSameLine[1])) {
                    throw \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception\TwoClosuresOnSameLine::create($this->fileName, $this->startLine);
                }
                return $closureNodesDataOnSameLine[0];
            }
        };
        $fileContents = \file_get_contents($fileName);
        $ast = $this->parser->parse($fileContents);
        $nodeTraverser = new \_PhpScopere8e811afab72\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($nodeVisitor);
        $nodeTraverser->traverse($ast);
        $closureNodes = $nodeVisitor->getClosureNodes();
        \assert(\is_array($closureNodes));
        \assert($closureNodes[1] instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ || $closureNodes[1] === null);
        $reflectionFunction = (new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection())->__invoke($reflector, $closureNodes[0], new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource($fileContents, $fileName), $closureNodes[1]);
        \assert($reflectionFunction instanceof \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction || $reflectionFunction === null);
        return $reflectionFunction;
    }
}
