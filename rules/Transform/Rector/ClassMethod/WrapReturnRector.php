<?php

declare(strict_types=1);

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
use Webmozart\Assert\Assert;

/**
 * @see \Rector\Tests\Transform\Rector\ClassMethod\WrapReturnRector\WrapReturnRectorTest
 */
final class WrapReturnRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var string
     */
    const TYPE_METHOD_WRAPS = 'type_method_wraps';

    /**
     * @var WrapReturn[]
     */
    private $typeMethodWraps = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Wrap return value of specific method', [
            new ConfiguredCodeSample(
                <<<'CODE_SAMPLE'
final class SomeClass
{
    public function getItem()
    {
        return 1;
    }
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
final class SomeClass
{
    public function getItem()
    {
        return [1];
    }
}
CODE_SAMPLE
                ,
                [
                    self::TYPE_METHOD_WRAPS => [new WrapReturn('SomeClass', 'getItem', true)],
                ]
            ),
        ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [ClassMethod::class];
    }

    /**
     * @param ClassMethod $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        foreach ($this->typeMethodWraps as $typeMethodWrap) {
            if (! $this->isObjectType($node, $typeMethodWrap->getObjectType())) {
                continue;
            }

            if (! $this->isName($node, $typeMethodWrap->getMethod())) {
                continue;
            }

            if (! $node->stmts) {
                continue;
            }

            return $this->wrap($node, $typeMethodWrap->isArrayWrap());
        }

        return $node;
    }

    /**
     * @return void
     */
    public function configure(array $configuration)
    {
        $typeMethodWraps = $configuration[self::TYPE_METHOD_WRAPS] ?? [];
        Assert::allIsInstanceOf($typeMethodWraps, WrapReturn::class);
        $this->typeMethodWraps = $typeMethodWraps;
    }

    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    private function wrap(ClassMethod $classMethod, bool $isArrayWrap)
    {
        if (! is_iterable($classMethod->stmts)) {
            return null;
        }

        foreach ($classMethod->stmts as $key => $stmt) {
            if ($stmt instanceof Return_ && $stmt->expr !== null) {
                if ($isArrayWrap && ! $stmt->expr instanceof Array_) {
                    $stmt->expr = new Array_([new ArrayItem($stmt->expr)]);
                }

                $classMethod->stmts[$key] = $stmt;
            }
        }

        return $classMethod;
    }
}
