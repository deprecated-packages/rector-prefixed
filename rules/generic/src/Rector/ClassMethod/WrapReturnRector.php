<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\WrapReturn;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\ClassMethod\WrapReturnRector\WrapReturnRectorTest
 */
final class WrapReturnRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const TYPE_METHOD_WRAPS = 'type_method_wraps';
    /**
     * @var WrapReturn[]
     */
    private $typeMethodWraps = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Wrap return value of specific method', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function getItem()
    {
        return 1;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function getItem()
    {
        return [1];
    }
}
CODE_SAMPLE
, [self::TYPE_METHOD_WRAPS => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\WrapReturn('SomeClass', 'getItem', \true)]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->typeMethodWraps as $typeMethodWrap) {
            if (!$this->isObjectType($node, $typeMethodWrap->getType())) {
                continue;
            }
            if (!$this->isName($node, $typeMethodWrap->getMethod())) {
                continue;
            }
            if (!$node->stmts) {
                continue;
            }
            return $this->wrap($node, $typeMethodWrap->isArrayWrap());
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $typeMethodWraps = $configuration[self::TYPE_METHOD_WRAPS] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($typeMethodWraps, \_PhpScopere8e811afab72\Rector\Generic\ValueObject\WrapReturn::class);
        $this->typeMethodWraps = $typeMethodWraps;
    }
    private function wrap(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, bool $isArrayWrap) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        if (!\is_iterable($classMethod->stmts)) {
            return null;
        }
        foreach ((array) $classMethod->stmts as $key => $stmt) {
            if ($stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ && $stmt->expr !== null) {
                if ($isArrayWrap && !$stmt->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_) {
                    $stmt->expr = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_([new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem($stmt->expr)]);
                }
                $classMethod->stmts[$key] = $stmt;
            }
        }
        return $classMethod;
    }
}
