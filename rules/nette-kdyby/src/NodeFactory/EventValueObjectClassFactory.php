<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\NodeFactory;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\ClassBuilder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\NamespaceBuilder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\BlueprintFactory\VariableWithTypesFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\ValueObject\VariableWithType;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\BlueprintFactory\VariableWithTypesFactory $variableWithTypesFactory)
    {
        $this->classNaming = $classNaming;
        $this->variableWithTypesFactory = $variableWithTypesFactory;
        $this->nodeFactory = $nodeFactory;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param Arg[] $args
     */
    public function create(string $className, array $args) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_
    {
        $classBuilder = $this->createEventClassBuilder($className);
        $this->decorateWithConstructorIfHasArgs($classBuilder, $args);
        $class = $classBuilder->getNode();
        return $this->wrapClassToNamespace($className, $class);
    }
    private function createEventClassBuilder(string $className) : \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\ClassBuilder
    {
        $shortClassName = $this->classNaming->getShortName($className);
        $classBuilder = new \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\ClassBuilder($shortClassName);
        $classBuilder->makeFinal();
        $classBuilder->extend(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified('_PhpScoper2a4e7ab1ecbc\\Symfony\\Contracts\\EventDispatcher\\Event'));
        return $classBuilder;
    }
    /**
     * @param Arg[] $args
     */
    private function decorateWithConstructorIfHasArgs(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\ClassBuilder $classBuilder, array $args) : void
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
    private function wrapClassToNamespace(string $className, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_
    {
        $namespace = \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::before($className, '\\', -1);
        $namespaceBuilder = new \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\NamespaceBuilder($namespace);
        $namespaceBuilder->addStmt($class);
        return $namespaceBuilder->getNode();
    }
    /**
     * @param VariableWithType[] $variablesWithTypes
     */
    private function ensureVariablesAreUnique(array $variablesWithTypes, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\ClassBuilder $classBuilder) : void
    {
        $usedVariableNames = [];
        foreach ($variablesWithTypes as $variablesWithType) {
            if (\in_array($variablesWithType->getName(), $usedVariableNames, \true)) {
                $className = $this->nodeNameResolver->getName($classBuilder->getNode());
                $message = \sprintf('Variable "$%s" is duplicated in to be created "%s" class', $variablesWithType->getName(), $className);
                throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException($message);
            }
            $usedVariableNames[] = $variablesWithType->getName();
        }
    }
    /**
     * @param VariableWithType[] $variableWithTypes
     */
    private function createConstructClassMethod(array $variableWithTypes) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\MethodBuilder(\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $methodBuilder->makePublic();
        foreach ($variableWithTypes as $variableWithType) {
            $param = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable($variableWithType->getName()));
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
