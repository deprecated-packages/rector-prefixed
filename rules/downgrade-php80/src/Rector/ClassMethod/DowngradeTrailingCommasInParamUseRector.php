<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DowngradePhp80\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClosureUse;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp80\Tests\Rector\ClassMethod\DowngradeTrailingCommasInParamUseRector\DowngradeTrailingCommasInParamUseRectorTest
 */
final class DowngradeTrailingCommasInParamUseRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove trailing commas in param or use list', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param ClassMethod|Function_|Closure|FuncCall|MethodCall|StaticCall|New_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall || $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall || $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_) {
            return $this->processArgs($node);
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure) {
            $node = $this->processUses($node);
        }
        return $this->processParams($node);
    }
    /**
     * @param FuncCall|MethodCall|StaticCall|New_ $node
     */
    private function processArgs(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node->args === []) {
            return null;
        }
        return $this->cleanTrailingComma($node, $node->args);
    }
    private function processUses(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure $node) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure
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
    private function processParams(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node->params === []) {
            return null;
        }
        return $this->cleanTrailingComma($node, $node->params);
    }
    /**
     * @param ClosureUse[]|Param[]|Arg[] $array
     */
    private function cleanTrailingComma(\_PhpScoper0a6b37af0871\PhpParser\Node $node, array $array) : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $node->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        $last = $array[\array_key_last($array)];
        $last->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FUNC_ARGS_TRAILING_COMMA, \false);
        return $node;
    }
}
