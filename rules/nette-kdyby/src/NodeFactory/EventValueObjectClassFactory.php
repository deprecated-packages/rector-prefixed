<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteKdyby\NodeFactory;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ClassBuilder;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\NamespaceBuilder;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\NetteKdyby\BlueprintFactory\VariableWithTypesFactory;
use _PhpScoper0a6b37af0871\Rector\NetteKdyby\ValueObject\VariableWithType;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
/**
 * @todo decouple to generic object factory for better re-use, e.g. this is just value object pattern
 */
final class EventValueObjectClassFactory
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var VariableWithTypesFactory
     */
    private $variableWithTypesFactory;
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\NetteKdyby\BlueprintFactory\VariableWithTypesFactory $variableWithTypesFactory)
    {
        $this->classNaming = $classNaming;
        $this->variableWithTypesFactory = $variableWithTypesFactory;
        $this->nodeFactory = $nodeFactory;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param Arg[] $args
     */
    public function create(string $className, array $args) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_
    {
        $classBuilder = $this->createEventClassBuilder($className);
        $this->decorateWithConstructorIfHasArgs($classBuilder, $args);
        $class = $classBuilder->getNode();
        return $this->wrapClassToNamespace($className, $class);
    }
    private function createEventClassBuilder(string $className) : \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ClassBuilder
    {
        $shortClassName = $this->classNaming->getShortName($className);
        $classBuilder = new \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ClassBuilder($shortClassName);
        $classBuilder->makeFinal();
        $classBuilder->extend(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('_PhpScoper0a6b37af0871\\Symfony\\Contracts\\EventDispatcher\\Event'));
        return $classBuilder;
    }
    /**
     * @param Arg[] $args
     */
    private function decorateWithConstructorIfHasArgs(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ClassBuilder $classBuilder, array $args) : void
    {
        if ($args === []) {
            return;
        }
        $variablesWithTypes = $this->variableWithTypesFactory->createVariablesWithTypesFromArgs($args);
        $this->ensureVariablesAreUnique($variablesWithTypes, $classBuilder);
        $classMethod = $this->createConstructClassMethod($variablesWithTypes);
        $classBuilder->addStmt($classMethod);
        // add properties
        foreach ($variablesWithTypes as $variableWithType) {
            $property = $this->nodeFactory->createPrivatePropertyFromNameAndType($variableWithType->getName(), $variableWithType->getType());
            $classBuilder->addStmt($property);
        }
        // add getters
        foreach ($variablesWithTypes as $variableWithType) {
            $getterClassMethod = $this->nodeFactory->createGetterClassMethodFromNameAndType($variableWithType->getName(), $variableWithType->getPhpParserTypeNode());
            $classBuilder->addStmt($getterClassMethod);
        }
    }
    private function wrapClassToNamespace(string $className, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_
    {
        $namespace = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::before($className, '\\', -1);
        $namespaceBuilder = new \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\NamespaceBuilder($namespace);
        $namespaceBuilder->addStmt($class);
        return $namespaceBuilder->getNode();
    }
    /**
     * @param VariableWithType[] $variablesWithTypes
     */
    private function ensureVariablesAreUnique(array $variablesWithTypes, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ClassBuilder $classBuilder) : void
    {
        $usedVariableNames = [];
        foreach ($variablesWithTypes as $variablesWithType) {
            if (\in_array($variablesWithType->getName(), $usedVariableNames, \true)) {
                $className = $this->nodeNameResolver->getName($classBuilder->getNode());
                $message = \sprintf('Variable "$%s" is duplicated in to be created "%s" class', $variablesWithType->getName(), $className);
                throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException($message);
            }
            $usedVariableNames[] = $variablesWithType->getName();
        }
    }
    /**
     * @param VariableWithType[] $variableWithTypes
     */
    private function createConstructClassMethod(array $variableWithTypes) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\MethodBuilder(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $methodBuilder->makePublic();
        foreach ($variableWithTypes as $variableWithType) {
            $param = new \_PhpScoper0a6b37af0871\PhpParser\Node\Param(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($variableWithType->getName()));
            if ($variableWithType->getPhpParserTypeNode() !== null) {
                $param->type = $variableWithType->getPhpParserTypeNode();
            }
            $methodBuilder->addParam($param);
            $assign = $this->nodeFactory->createPropertyAssignment($variableWithType->getName());
            $methodBuilder->addStmt($assign);
        }
        return $methodBuilder->getNode();
    }
}
