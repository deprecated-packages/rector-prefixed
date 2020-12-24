<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Rector\Variable;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Collector\VariablesToPropertyFetchCollection;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\Class_\ActionInjectionToConstructorInjectionRector\ActionInjectionToConstructorInjectionRectorTest
 */
final class ReplaceVariableByPropertyFetchRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var VariablesToPropertyFetchCollection
     */
    private $variablesToPropertyFetchCollection;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\Configuration\Collector\VariablesToPropertyFetchCollection $variablesToPropertyFetchCollection)
    {
        $this->variablesToPropertyFetchCollection = $variablesToPropertyFetchCollection;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns variable in controller action to property fetch, as follow up to action injection variable to property change.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable::class];
    }
    /**
     * @param Variable $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isInControllerActionMethod($node)) {
            return null;
        }
        foreach ($this->variablesToPropertyFetchCollection->getVariableNamesAndTypes() as $name => $type) {
            if (!$this->isName($node, $name)) {
                continue;
            }
            /** @var ObjectType $type */
            if (!$this->isObjectType($node, $type)) {
                continue;
            }
            return $this->createPropertyFetch('this', $name);
        }
        return null;
    }
    private function isInControllerActionMethod(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : bool
    {
        /** @var string|null $className */
        $className = $variable->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return \false;
        }
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($className, 'Controller')) {
            return \false;
        }
        /** @var ClassMethod|null $classMethod */
        $classMethod = $variable->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethod === null) {
            return \false;
        }
        // is probably in controller action
        return $classMethod->isPublic();
    }
}
