<?php

declare (strict_types=1);
namespace Rector\Utils\PHPStanAttributeTypeSyncer\NodeFactory;

use _PhpScoper006a73f0e455\Nette\Utils\Strings;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Return_;
use PHPStan\PhpDocParser\Ast\Node;
use Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use Rector\Core\PhpParser\Builder\ClassBuilder;
use Rector\Core\PhpParser\Builder\MethodBuilder;
use Rector\Core\PhpParser\Builder\NamespaceBuilder;
use Rector\Core\PhpParser\Builder\ParamBuilder;
use Rector\Utils\PHPStanAttributeTypeSyncer\ClassNaming\AttributeClassNaming;
use Rector\Utils\PHPStanAttributeTypeSyncer\ValueObject\Paths;
use ReflectionClass;
final class AttributeAwareClassFactoryFactory
{
    /**
     * @var string
     */
    private const NODE = 'node';
    /**
     * @var AttributeClassNaming
     */
    private $attributeClassNaming;
    public function __construct(\Rector\Utils\PHPStanAttributeTypeSyncer\ClassNaming\AttributeClassNaming $attributeClassNaming)
    {
        $this->attributeClassNaming = $attributeClassNaming;
    }
    public function createFromPhpDocParserNodeClass(string $nodeClass) : \PhpParser\Node\Stmt\Namespace_
    {
        if (\_PhpScoper006a73f0e455\Nette\Utils\Strings::contains($nodeClass, '\\Type\\')) {
            $namespace = \Rector\Utils\PHPStanAttributeTypeSyncer\ValueObject\Paths::NAMESPACE_TYPE_NODE_FACTORY;
        } else {
            $namespace = \Rector\Utils\PHPStanAttributeTypeSyncer\ValueObject\Paths::NAMESPACE_PHPDOC_NODE_FACTORY;
        }
        $namespaceBuilder = new \Rector\Core\PhpParser\Builder\NamespaceBuilder($namespace);
        $shortClassName = $this->attributeClassNaming->createAttributeAwareFactoryShortClassName($nodeClass);
        $classBuilder = new \Rector\Core\PhpParser\Builder\ClassBuilder($shortClassName);
        $classBuilder->makeFinal();
        $classBuilder->implement(new \PhpParser\Node\Name\FullyQualified(\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeNodeAwareFactoryInterface::class));
        $classMethods = $this->createClassMethods($nodeClass);
        $classBuilder->addStmts($classMethods);
        $namespaceBuilder->addStmt($classBuilder->getNode());
        return $namespaceBuilder->getNode();
    }
    /**
     * @return ClassMethod[]
     */
    private function createClassMethods(string $nodeClass) : array
    {
        $classMethods = [];
        $classMethods[] = $this->createGetOriginalNodeClass($nodeClass);
        $paramBuilder = new \Rector\Core\PhpParser\Builder\ParamBuilder(self::NODE);
        $paramBuilder->setType(new \PhpParser\Node\Name\FullyQualified(\PHPStan\PhpDocParser\Ast\Node::class));
        $classMethods[] = $this->createIsMatchClassMethod($nodeClass, $paramBuilder);
        $classMethods[] = $this->createCreateClassMethod($nodeClass);
        return $classMethods;
    }
    private function createGetOriginalNodeClass(string $nodeClass) : \PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \Rector\Core\PhpParser\Builder\MethodBuilder('getOriginalNodeClass');
        $methodBuilder->makePublic();
        $methodBuilder->setReturnType('string');
        $classConstFetch = $this->createClassReference($nodeClass);
        $methodBuilder->addStmt(new \PhpParser\Node\Stmt\Return_($classConstFetch));
        return $methodBuilder->getNode();
    }
    private function createIsMatchClassMethod(string $nodeClass, \Rector\Core\PhpParser\Builder\ParamBuilder $paramBuilder) : \PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \Rector\Core\PhpParser\Builder\MethodBuilder('isMatch');
        $methodBuilder->addParam($paramBuilder);
        $methodBuilder->makePublic();
        $methodBuilder->setReturnType('bool');
        $isAFuncCall = $this->createIsAFuncCall($nodeClass);
        $methodBuilder->addStmt(new \PhpParser\Node\Stmt\Return_($isAFuncCall));
        return $methodBuilder->getNode();
    }
    private function createCreateClassMethod(string $nodeClass) : \PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \Rector\Core\PhpParser\Builder\MethodBuilder('create');
        $paramBuilder = new \Rector\Core\PhpParser\Builder\ParamBuilder('docContent');
        $paramBuilder->setType('string');
        $docContentParam = $paramBuilder->getNode();
        $methodBuilder->addParam($paramBuilder);
        $methodBuilder->addParam($docContentParam);
        $methodBuilder->makePublic();
        $methodBuilder->setReturnType(new \PhpParser\Node\Name\FullyQualified(\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface::class));
        // add @paramBuilder doc with more precise type
        $paramDocBlock = \sprintf('/**%s * @paramBuilder \\%s%s */', \PHP_EOL, $nodeClass, \PHP_EOL);
        $methodBuilder->setDocComment($paramDocBlock);
        $attributeAwareClassName = $this->attributeClassNaming->createAttributeAwareClassName($nodeClass);
        $new = new \PhpParser\Node\Expr\New_(new \PhpParser\Node\Name\FullyQualified($attributeAwareClassName));
        // complete new args
        $this->completeNewArgs($new, $nodeClass);
        $methodBuilder->addStmt(new \PhpParser\Node\Stmt\Return_($new));
        return $methodBuilder->getNode();
    }
    private function createClassReference(string $nodeClass) : \PhpParser\Node\Expr\ClassConstFetch
    {
        return new \PhpParser\Node\Expr\ClassConstFetch(new \PhpParser\Node\Name\FullyQualified($nodeClass), 'class');
    }
    private function createIsAFuncCall(string $nodeClass) : \PhpParser\Node\Expr\FuncCall
    {
        $variable = new \PhpParser\Node\Expr\Variable(self::NODE);
        $constFetch = new \PhpParser\Node\Expr\ConstFetch(new \PhpParser\Node\Name('true'));
        $args = [new \PhpParser\Node\Arg($variable), new \PhpParser\Node\Arg($this->createClassReference($nodeClass)), new \PhpParser\Node\Arg($constFetch)];
        return new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name('is_a'), $args);
    }
    private function completeNewArgs(\PhpParser\Node\Expr\New_ $new, string $phpDocParserNodeClass) : void
    {
        // ...
        $reflectionClass = new \ReflectionClass($phpDocParserNodeClass);
        $constructorReflectionMethod = $reflectionClass->getConstructor();
        // no constructor → no params to add
        if ($constructorReflectionMethod === null) {
            return;
        }
        $phpDocParserNodeVariable = new \PhpParser\Node\Expr\Variable(self::NODE);
        foreach ($constructorReflectionMethod->getParameters() as $reflectionParameter) {
            $parameterName = $reflectionParameter->getName();
            $new->args[] = new \PhpParser\Node\Arg(new \PhpParser\Node\Expr\PropertyFetch($phpDocParserNodeVariable, $parameterName));
        }
    }
}
