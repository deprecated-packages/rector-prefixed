<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\Encapsed;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Parser\InlineCodeParser;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/q/48161526/1348344
 * @see http://php.net/manual/en/migration72.deprecated.php#migration72.deprecated.create_function-function
 *
 * @see \Rector\Php72\Tests\Rector\FuncCall\CreateFunctionToAnonymousFunctionRector\CreateFunctionToAnonymousFunctionRectorTest
 */
final class CreateFunctionToAnonymousFunctionRector extends \_PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall\AbstractConvertToAnonymousFunctionRector
{
    /**
     * @var InlineCodeParser
     */
    private $inlineCodeParser;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Parser\InlineCodeParser $inlineCodeParser)
    {
        $this->inlineCodeParser = $inlineCodeParser;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use anonymous functions instead of deprecated create_function()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class ClassWithCreateFunction
{
    public function run()
    {
        $callable = create_function('$matches', "return '$delimiter' . strtolower(\$matches[1]);");
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class ClassWithCreateFunction
{
    public function run()
    {
        $callable = function($matches) use ($delimiter) {
            return $delimiter . strtolower($matches[1]);
        };
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return !$this->isName($node, 'create_function');
    }
    /**
     * @param FuncCall $node
     * @return Param[]
     */
    public function getParameters(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        return $this->parseStringToParameters($node->args[0]->value);
    }
    /**
     * @return Identifier|Name|NullableType|UnionType|null
     */
    public function getReturnType(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return null;
    }
    /**
     * @param FuncCall $node
     * @return Stmt[]
     */
    public function getBody(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        return $this->parseStringToBody($node->args[1]->value);
    }
    /**
     * @return Param[]
     */
    private function parseStringToParameters(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : array
    {
        $content = $this->inlineCodeParser->stringify($expr);
        $content = '<?php $value = function(' . $content . ') {};';
        $nodes = $this->inlineCodeParser->parse($content);
        /** @var Expression $expression */
        $expression = $nodes[0];
        /** @var Assign $assign */
        $assign = $expression->expr;
        /** @var Closure $function */
        $function = $assign->expr;
        if (!$function instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $function->params;
    }
    /**
     * @return Expression[]|Stmt[]
     */
    private function parseStringToBody(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : array
    {
        if (!$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_ && !$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\Encapsed && !$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat) {
            // special case of code elsewhere
            return [$this->createEval($expr)];
        }
        $expr = $this->inlineCodeParser->stringify($expr);
        return $this->inlineCodeParser->parse($expr);
    }
    private function createEval(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $evalFuncCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall(new \_PhpScopere8e811afab72\PhpParser\Node\Name('eval'), [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($expr)]);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($evalFuncCall);
    }
}
