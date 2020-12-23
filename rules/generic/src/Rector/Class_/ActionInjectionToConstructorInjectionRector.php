<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\Rector\Class_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Collector\VariablesToPropertyFetchCollection;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Symfony\ServiceMapProvider;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\Class_\ActionInjectionToConstructorInjectionRector\ActionInjectionToConstructorInjectionRectorTest
 */
final class ActionInjectionToConstructorInjectionRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var VariablesToPropertyFetchCollection
     */
    private $variablesToPropertyFetchCollection;
    /**
     * @var ServiceMapProvider
     */
    private $applicationServiceMapProvider;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Symfony\ServiceMapProvider $applicationServiceMapProvider, \_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Collector\VariablesToPropertyFetchCollection $variablesToPropertyFetchCollection)
    {
        $this->variablesToPropertyFetchCollection = $variablesToPropertyFetchCollection;
        $this->applicationServiceMapProvider = $applicationServiceMapProvider;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns action injection in Controllers to constructor injection', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeController
{
    public function default(ProductRepository $productRepository)
    {
        $products = $productRepository->fetchAll();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function default()
    {
        $products = $this->productRepository->fetchAll();
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isName($node, '*Controller')) {
            return null;
        }
        foreach ($node->getMethods() as $classMethod) {
            $this->processClassMethod($node, $classMethod);
        }
        return $node;
    }
    private function processClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        foreach ($classMethod->params as $key => $paramNode) {
            if (!$this->isActionInjectedParamNode($paramNode)) {
                continue;
            }
            $paramNodeType = $this->getObjectType($paramNode);
            /** @var string $paramName */
            $paramName = $this->getName($paramNode->var);
            $this->addConstructorDependencyToClass($class, $paramNodeType, $paramName);
            $this->removeParam($classMethod, $key);
            $this->variablesToPropertyFetchCollection->addVariableNameAndType($paramName, $paramNodeType);
        }
    }
    private function isActionInjectedParamNode(\_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param) : bool
    {
        if ($param->type === null) {
            return \false;
        }
        $typehint = $this->getName($param->type);
        if ($typehint === null) {
            return \false;
        }
        $paramStaticType = $this->getObjectType($param);
        if (!$paramStaticType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType) {
            return \false;
        }
        $serviceMap = $this->applicationServiceMapProvider->provide();
        return $serviceMap->hasService($paramStaticType->getClassName());
    }
}
