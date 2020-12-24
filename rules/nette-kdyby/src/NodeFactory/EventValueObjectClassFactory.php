<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby\NodeFactory;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ClassBuilder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\NamespaceBuilder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NetteKdyby\BlueprintFactory\VariableWithTypesFactory;
use _PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject\VariableWithType;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NetteKdyby\BlueprintFactory\VariableWithTypesFactory $variableWithTypesFactory)
    {
        $this->classNaming = $classNaming;
        $this->variableWithTypesFactory = $variableWithTypesFactory;
        $this->nodeFactory = $nodeFactory;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param Arg[] $args
     */
    public function create(string $className, array $args) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_
    {
        $classBuilder = $this->createEventClassBuilder($className);
        $this->decorateWithConstructorIfHasArgs($classBuilder, $args);
        $class = $classBuilder->getNode();
        return $this->wrapClassToNamespace($className, $class);
    }
    private function createEventClassBuilder(string $className) : \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ClassBuilder
    {
        $shortClassName = $this->classNaming->getShortName($className);
        $classBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ClassBuilder($shortClassName);
        $classBuilder->makeFinal();
        $classBuilder->extend(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('_PhpScopere8e811afab72\\Symfony\\Contracts\\EventDispatcher\\Event'));
        return $classBuilder;
    }
    /**
     * @param Arg[] $args
     */
    private function decorateWithConstructorIfHasArgs(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ClassBuilder $classBuilder, array $args) : void
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
    private function wrapClassToNamespace(string $className, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_
    {
        $namespace = \_PhpScopere8e811afab72\Nette\Utils\Strings::before($className, '\\', -1);
        $namespaceBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\NamespaceBuilder($namespace);
        $namespaceBuilder->addStmt($class);
        return $namespaceBuilder->getNode();
    }
    /**
     * @param VariableWithType[] $variablesWithTypes
     */
    private function ensureVariablesAreUnique(array $variablesWithTypes, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ClassBuilder $classBuilder) : void
    {
        $usedVariableNames = [];
        foreach ($variablesWithTypes as $variablesWithType) {
            if (\in_array($variablesWithType->getName(), $usedVariableNames, \true)) {
                $className = $this->nodeNameResolver->getName($classBuilder->getNode());
                $message = \sprintf('Variable "$%s" is duplicated in to be created "%s" class', $variablesWithType->getName(), $className);
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException($message);
            }
            $usedVariableNames[] = $variablesWithType->getName();
        }
    }
    /**
     * @param VariableWithType[] $variableWithTypes
     */
    private function createConstructClassMethod(array $variableWithTypes) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $methodBuilder->makePublic();
        foreach ($variableWithTypes as $variableWithType) {
            $param = new \_PhpScopere8e811afab72\PhpParser\Node\Param(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($variableWithType->getName()));
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
