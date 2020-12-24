<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type;

use Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract;
use _PhpScoper0a6b37af0871\PhpParser\Parser;
use ReflectionFunction as CoreFunctionReflection;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Exception\ParseToAstFailure;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception\EvaledClosureCannotBeLocated;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception\TwoClosuresOnSameLine;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\FileChecker;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\FileHelper;
use function array_filter;
use function array_values;
use function assert;
use function file_get_contents;
use function is_array;
use function strpos;
/**
 * @internal
 */
final class ClosureSourceLocator implements \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var CoreFunctionReflection */
    private $coreFunctionReflection;
    /** @var Parser */
    private $parser;
    public function __construct(\Closure $closure, \_PhpScoper0a6b37af0871\PhpParser\Parser $parser)
    {
        $this->coreFunctionReflection = new \ReflectionFunction($closure);
        $this->parser = $parser;
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public function locateIdentifier(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        return $this->getReflectionFunction($reflector, $identifier->getType());
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public function locateIdentifiersByType(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return \array_filter([$this->getReflectionFunction($reflector, $identifierType)]);
    }
    private function getReflectionFunction(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : ?\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction
    {
        if (!$identifierType->isFunction()) {
            return null;
        }
        $fileName = $this->coreFunctionReflection->getFileName();
        if (\strpos($fileName, 'eval()\'d code') !== \false) {
            throw \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception\EvaledClosureCannotBeLocated::create();
        }
        \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\FileChecker::assertReadableFile($fileName);
        $fileName = \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\FileHelper::normalizeWindowsPath($fileName);
        $nodeVisitor = new class($fileName, $this->coreFunctionReflection->getStartLine()) extends \_PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract
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
            public function enterNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node)
            {
                if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_) {
                    $this->currentNamespace = $node;
                    return null;
                }
                if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure) {
                    return null;
                }
                $this->closureNodes[] = [$node, $this->currentNamespace];
                return null;
            }
            /**
             * {@inheritDoc}
             */
            public function leaveNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node)
            {
                if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_) {
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
                    throw \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception\TwoClosuresOnSameLine::create($this->fileName, $this->startLine);
                }
                return $closureNodesDataOnSameLine[0];
            }
        };
        $fileContents = \file_get_contents($fileName);
        $ast = $this->parser->parse($fileContents);
        $nodeTraverser = new \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($nodeVisitor);
        $nodeTraverser->traverse($ast);
        $closureNodes = $nodeVisitor->getClosureNodes();
        \assert(\is_array($closureNodes));
        \assert($closureNodes[1] instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_ || $closureNodes[1] === null);
        $reflectionFunction = (new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection())->__invoke($reflector, $closureNodes[0], new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource($fileContents, $fileName), $closureNodes[1]);
        \assert($reflectionFunction instanceof \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction || $reflectionFunction === null);
        return $reflectionFunction;
    }
}
