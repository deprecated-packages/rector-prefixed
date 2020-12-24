<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClosureUse;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp80\Tests\Rector\ClassMethod\DowngradeTrailingCommasInParamUseRector\DowngradeTrailingCommasInParamUseRectorTest
 */
final class DowngradeTrailingCommasInParamUseRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove trailing commas in param or use list', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct(string $value1, string $value2,)
    {
        function (string $value1, string $value2,) {
        };

        function () use ($value1, $value2,) {
        };
    }
}

function inFunction(string $value1, string $value2,)
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct(string $value1, string $value2)
    {
        function (string $value1, string $value2) {
        };

        function () use ($value1, $value2) {
        };
    }
}

function inFunction(string $value1, string $value2)
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param ClassMethod|Function_|Closure|FuncCall|MethodCall|StaticCall|New_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_) {
            return $this->processArgs($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure) {
            $node = $this->processUses($node);
        }
        return $this->processParams($node);
    }
    /**
     * @param FuncCall|MethodCall|StaticCall|New_ $node
     */
    private function processArgs(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node->args === []) {
            return null;
        }
        return $this->cleanTrailingComma($node, $node->args);
    }
    private function processUses(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure $node) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure
    {
        if ($node->uses === []) {
            return $node;
        }
        /** @var Closure $clean */
        $clean = $this->cleanTrailingComma($node, $node->uses);
        return $clean;
    }
    /**
     * @param ClassMethod|Function_|Closure $node
     */
    private function processParams(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node->params === []) {
            return null;
        }
        return $this->cleanTrailingComma($node, $node->params);
    }
    /**
     * @param ClosureUse[]|Param[]|Arg[] $array
     */
    private function cleanTrailingComma(\_PhpScopere8e811afab72\PhpParser\Node $node, array $array) : \_PhpScopere8e811afab72\PhpParser\Node
    {
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        $last = $array[\array_key_last($array)];
        $last->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FUNC_ARGS_TRAILING_COMMA, \false);
        return $node;
    }
}
