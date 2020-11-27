<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Type;

use InvalidArgumentException;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Parser;
use ReflectionClass as CoreReflectionClass;
use ReflectionException;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionClass;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Ast\Exception\ParseToAstFailure;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Exception\EvaledAnonymousClassCannotBeLocated;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Exception\TwoAnonymousClassesOnSameLine;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\FileChecker;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Util\FileHelper;
use function array_filter;
use function array_values;
use function assert;
use function file_get_contents;
use function gettype;
use function is_object;
use function sprintf;
use function strpos;
/**
 * @internal
 */
final class AnonymousClassObjectSourceLocator implements \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var CoreReflectionClass */
    private $coreClassReflection;
    /** @var Parser */
    private $parser;
    /**
     * @param object $anonymousClassObject
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
     *
     * @psalm-suppress DocblockTypeContradiction
     */
    public function __construct($anonymousClassObject, \PhpParser\Parser $parser)
    {
        if (!\is_object($anonymousClassObject)) {
            throw new \InvalidArgumentException(\sprintf('Can only create from an instance of an object, "%s" given', \gettype($anonymousClassObject)));
        }
        $this->coreClassReflection = new \ReflectionClass($anonymousClassObject);
        $this->parser = $parser;
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public function locateIdentifier(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Reflection
    {
        return $this->getReflectionClass($reflector, $identifier->getType());
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public function locateIdentifiersByType(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return \array_filter([$this->getReflectionClass($reflector, $identifierType)]);
    }
    private function getReflectionClass(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : ?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionClass
    {
        if (!$identifierType->isClass()) {
            return null;
        }
        $fileName = $this->coreClassReflection->getFileName();
        if (\strpos($fileName, 'eval()\'d code') !== \false) {
            throw \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Exception\EvaledAnonymousClassCannotBeLocated::create();
        }
        \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\FileChecker::assertReadableFile($fileName);
        $fileName = \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Util\FileHelper::normalizeWindowsPath($fileName);
        $nodeVisitor = new class($fileName, $this->coreClassReflection->getStartLine()) extends \PhpParser\NodeVisitorAbstract
        {
            /** @var string */
            private $fileName;
            /** @var int */
            private $startLine;
            /** @var Class_[] */
            private $anonymousClassNodes = [];
            public function __construct(string $fileName, int $startLine)
            {
                $this->fileName = $fileName;
                $this->startLine = $startLine;
            }
            /**
             * {@inheritDoc}
             */
            public function enterNode(\PhpParser\Node $node)
            {
                if (!$node instanceof \PhpParser\Node\Stmt\Class_ || $node->name !== null) {
                    return null;
                }
                $this->anonymousClassNodes[] = $node;
                return null;
            }
            public function getAnonymousClassNode() : ?\PhpParser\Node\Stmt\Class_
            {
                /** @var Class_[] $anonymousClassNodesOnSameLine */
                $anonymousClassNodesOnSameLine = \array_values(\array_filter($this->anonymousClassNodes, function (\PhpParser\Node\Stmt\Class_ $node) : bool {
                    return $node->getLine() === $this->startLine;
                }));
                if (!$anonymousClassNodesOnSameLine) {
                    return null;
                }
                if (isset($anonymousClassNodesOnSameLine[1])) {
                    throw \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Exception\TwoAnonymousClassesOnSameLine::create($this->fileName, $this->startLine);
                }
                return $anonymousClassNodesOnSameLine[0];
            }
        };
        $fileContents = \file_get_contents($fileName);
        $ast = $this->parser->parse($fileContents);
        $nodeTraverser = new \PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($nodeVisitor);
        $nodeTraverser->traverse($ast);
        $reflectionClass = (new \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection())->__invoke($reflector, $nodeVisitor->getAnonymousClassNode(), new \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource($fileContents, $fileName), null);
        \assert($reflectionClass instanceof \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionClass || $reflectionClass === null);
        return $reflectionClass;
    }
}
