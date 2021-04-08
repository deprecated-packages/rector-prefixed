<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Transform\ValueObject\WrapReturn;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210408\Webmozart\Assert\Assert;
/**
 * @see \Rector\Tests\Transform\Rector\ClassMethod\WrapReturnRector\WrapReturnRectorTest
 */
final class WrapReturnRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const TYPE_METHOD_WRAPS = 'type_method_wraps';
    /**
     * @var WrapReturn[]
     */
    private $typeMethodWraps = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Wrap return value of specific method', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::TYPE_METHOD_WRAPS => [new \Rector\Transform\ValueObject\WrapReturn('SomeClass', 'getItem', \true)]])]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->typeMethodWraps as $typeMethodWrap) {
            if (!$this->isObjectType($node, $typeMethodWrap->getObjectType())) {
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
        \RectorPrefix20210408\Webmozart\Assert\Assert::allIsInstanceOf($typeMethodWraps, \Rector\Transform\ValueObject\WrapReturn::class);
        $this->typeMethodWraps = $typeMethodWraps;
    }
    private function wrap(\PhpParser\Node\Stmt\ClassMethod $classMethod, bool $isArrayWrap) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        if (!\is_iterable($classMethod->stmts)) {
            return null;
        }
        foreach ($classMethod->stmts as $key => $stmt) {
            if ($stmt instanceof \PhpParser\Node\Stmt\Return_ && $stmt->expr !== null) {
                if ($isArrayWrap && !$stmt->expr instanceof \PhpParser\Node\Expr\Array_) {
                    $stmt->expr = new \PhpParser\Node\Expr\Array_([new \PhpParser\Node\Expr\ArrayItem($stmt->expr)]);
                }
                $classMethod->stmts[$key] = $stmt;
            }
        }
        return $classMethod;
    }
}
