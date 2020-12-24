<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\WrapReturn;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\ClassMethod\WrapReturnRector\WrapReturnRectorTest
 */
final class WrapReturnRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const TYPE_METHOD_WRAPS = 'type_method_wraps';
    /**
     * @var WrapReturn[]
     */
    private $typeMethodWraps = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Wrap return value of specific method', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::TYPE_METHOD_WRAPS => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\WrapReturn('SomeClass', 'getItem', \true)]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
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
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($typeMethodWraps, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\WrapReturn::class);
        $this->typeMethodWraps = $typeMethodWraps;
    }
    private function wrap(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, bool $isArrayWrap) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        if (!\is_iterable($classMethod->stmts)) {
            return null;
        }
        foreach ((array) $classMethod->stmts as $key => $stmt) {
            if ($stmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_ && $stmt->expr !== null) {
                if ($isArrayWrap && !$stmt->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_) {
                    $stmt->expr = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_([new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem($stmt->expr)]);
                }
                $classMethod->stmts[$key] = $stmt;
            }
        }
        return $classMethod;
    }
}
