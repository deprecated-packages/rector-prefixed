<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast;

use Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\PhpParser\NodeVisitor\NameResolver;
use _PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\AstConversionStrategy;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\ConstantNodeChecker;
use function assert;
use function count;
/**
 * @internal
 */
final class FindReflectionsInTree
{
    /** @var AstConversionStrategy */
    private $astConversionStrategy;
    /** @var FunctionReflector */
    private $functionReflector;
    /** @var Closure(): FunctionReflector */
    private $functionReflectorGetter;
    /**
     * @param Closure(): FunctionReflector $functionReflectorGetter
     */
    public function __construct(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\AstConversionStrategy $astConversionStrategy, \Closure $functionReflectorGetter)
    {
        $this->astConversionStrategy = $astConversionStrategy;
        $this->functionReflectorGetter = $functionReflectorGetter;
    }
    /**
     * Find all reflections of a given type in an Abstract Syntax Tree
     *
     * @param Node[] $ast
     *
     * @return Reflection[]
     */
    public function __invoke(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, array $ast, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $identifierType, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource) : array
    {
        $nodeVisitor = new class($reflector, $identifierType, $locatedSource, $this->astConversionStrategy, $this->functionReflectorGetter->__invoke()) extends \_PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract
        {
            /** @var Reflection[] */
            private $reflections = [];
            /** @var Reflector */
            private $reflector;
            /** @var IdentifierType */
            private $identifierType;
            /** @var LocatedSource */
            private $locatedSource;
            /** @var AstConversionStrategy */
            private $astConversionStrategy;
            /** @var Namespace_|null */
            private $currentNamespace;
            /** @var FunctionReflector */
            private $functionReflector;
            public function __construct(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $identifierType, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\AstConversionStrategy $astConversionStrategy, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector)
            {
                $this->reflector = $reflector;
                $this->identifierType = $identifierType;
                $this->locatedSource = $locatedSource;
                $this->astConversionStrategy = $astConversionStrategy;
                $this->functionReflector = $functionReflector;
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
                if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike) {
                    $classNamespace = $node->name === null ? null : $this->currentNamespace;
                    $reflection = $this->astConversionStrategy->__invoke($this->reflector, $node, $this->locatedSource, $classNamespace);
                    if ($this->identifierType->isMatchingReflector($reflection)) {
                        $this->reflections[] = $reflection;
                    }
                    return null;
                }
                if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst) {
                    return null;
                }
                if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Const_) {
                    for ($i = 0; $i < \count($node->consts); $i++) {
                        $reflection = $this->astConversionStrategy->__invoke($this->reflector, $node, $this->locatedSource, $this->currentNamespace, $i);
                        if (!$this->identifierType->isMatchingReflector($reflection)) {
                            continue;
                        }
                        $this->reflections[] = $reflection;
                    }
                    return null;
                }
                if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
                    try {
                        \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\ConstantNodeChecker::assertValidDefineFunctionCall($node);
                    } catch (\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode $e) {
                        return null;
                    }
                    if ($node->name->hasAttribute('namespacedName')) {
                        $namespacedName = $node->name->getAttribute('namespacedName');
                        \assert($namespacedName instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name);
                        if (\count($namespacedName->parts) > 1) {
                            try {
                                $this->functionReflector->reflect($namespacedName->toString());
                                return null;
                            } catch (\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                                // Global define()
                            }
                        }
                    }
                    $reflection = $this->astConversionStrategy->__invoke($this->reflector, $node, $this->locatedSource, $this->currentNamespace);
                    if ($this->identifierType->isMatchingReflector($reflection)) {
                        $this->reflections[] = $reflection;
                    }
                    return null;
                }
                if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_) {
                    return null;
                }
                $reflection = $this->astConversionStrategy->__invoke($this->reflector, $node, $this->locatedSource, $this->currentNamespace);
                if (!$this->identifierType->isMatchingReflector($reflection)) {
                    return null;
                }
                $this->reflections[] = $reflection;
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
             * @return Reflection[]
             */
            public function getReflections() : array
            {
                return $this->reflections;
            }
        };
        $nodeTraverser = new \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \_PhpScoper0a6b37af0871\PhpParser\NodeVisitor\NameResolver());
        $nodeTraverser->addVisitor($nodeVisitor);
        $nodeTraverser->traverse($ast);
        return $nodeVisitor->getReflections();
    }
}
