<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Collector\VariablesToPropertyFetchCollection;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Symfony\ServiceMapProvider;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\Class_\ActionInjectionToConstructorInjectionRector\ActionInjectionToConstructorInjectionRectorTest
 */
final class ActionInjectionToConstructorInjectionRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var VariablesToPropertyFetchCollection
     */
    private $variablesToPropertyFetchCollection;
    /**
     * @var ServiceMapProvider
     */
    private $applicationServiceMapProvider;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Symfony\ServiceMapProvider $applicationServiceMapProvider, \_PhpScoperb75b35f52b74\Rector\Core\Configuration\Collector\VariablesToPropertyFetchCollection $variablesToPropertyFetchCollection)
    {
        $this->variablesToPropertyFetchCollection = $variablesToPropertyFetchCollection;
        $this->applicationServiceMapProvider = $applicationServiceMapProvider;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns action injection in Controllers to constructor injection', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isName($node, '*Controller')) {
            return null;
        }
        foreach ($node->getMethods() as $classMethod) {
            $this->processClassMethod($node, $classMethod);
        }
        return $node;
    }
    private function processClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
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
    private function isActionInjectedParamNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : bool
    {
        if ($param->type === null) {
            return \false;
        }
        $typehint = $this->getName($param->type);
        if ($typehint === null) {
            return \false;
        }
        $paramStaticType = $this->getObjectType($param);
        if (!$paramStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return \false;
        }
        $serviceMap = $this->applicationServiceMapProvider->provide();
        return $serviceMap->hasService($paramStaticType->getClassName());
    }
}
