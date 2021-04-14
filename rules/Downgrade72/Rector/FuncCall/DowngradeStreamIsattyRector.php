<?php

declare (strict_types=1);
namespace Rector\Downgrade72\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp\BitwiseAnd;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\ErrorSuppress;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @changelog https://github.com/symfony/polyfill/commit/cc2bf55accd32b989348e2039e8c91cde46aebed
 *
 * @see \Rector\Tests\Downgrade72\Rector\FuncCall\DowngradeStreamIsattyRector\DowngradeStreamIsattyRectorTest
 */
final class DowngradeStreamIsattyRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const STAT = 'stat';
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Downgrade stream_isatty() function', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($stream)
    {
        $isStream = stream_isatty($stream);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($stream)
    {
        if ('\\' === \DIRECTORY_SEPARATOR)
            $stat = @fstat($stream);
            // Check if formatted mode is S_IFCHR
            $isStream = $stat ? 0020000 === ($stat['mode'] & 0170000) : false;
        } else {
            $isStream = @posix_isatty($stream)
        }
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isName($node, 'stream_isatty')) {
            return null;
        }
        $if = $this->createIf($node->args[0]->value);
        $function = new \PhpParser\Node\Expr\Closure();
        $function->params[] = new \PhpParser\Node\Param(new \PhpParser\Node\Expr\Variable('stream'));
        $function->stmts[] = $if;
        $posixIsatty = $this->nodeFactory->createFuncCall('posix_isatty', [$node->args[0]->value]);
        $function->stmts[] = new \PhpParser\Node\Stmt\Return_(new \PhpParser\Node\Expr\ErrorSuppress($posixIsatty));
        $assign = new \PhpParser\Node\Expr\Assign(new \PhpParser\Node\Expr\Variable('streamIsatty'), $function);
        $this->addNodeBeforeNode($assign, $node);
        return new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Expr\Variable('streamIsatty'), $node->args);
    }
    private function createIf(\PhpParser\Node\Expr $expr) : \PhpParser\Node\Stmt\If_
    {
        $constFetch = new \PhpParser\Node\Expr\ConstFetch(new \PhpParser\Node\Name\FullyQualified('DIRECTORY_SEPARATOR'));
        $identical = new \PhpParser\Node\Expr\BinaryOp\Identical(new \PhpParser\Node\Scalar\String_('\\'), $constFetch);
        $if = new \PhpParser\Node\Stmt\If_($identical);
        $statAssign = new \PhpParser\Node\Expr\Assign(new \PhpParser\Node\Expr\Variable(self::STAT), new \PhpParser\Node\Expr\ErrorSuppress($this->nodeFactory->createFuncCall('fstat', [$expr])));
        $if->stmts[] = new \PhpParser\Node\Stmt\Expression($statAssign);
        $arrayDimFetch = new \PhpParser\Node\Expr\ArrayDimFetch(new \PhpParser\Node\Expr\Variable(self::STAT), new \PhpParser\Node\Scalar\String_('mode'));
        $bitwiseAnd = new \PhpParser\Node\Expr\BinaryOp\BitwiseAnd($arrayDimFetch, new \PhpParser\Node\Scalar\LNumber(0170000, [\Rector\NodeTypeResolver\Node\AttributeKey::KIND => \PhpParser\Node\Scalar\LNumber::KIND_OCT]));
        $identical = new \PhpParser\Node\Expr\BinaryOp\Identical(new \PhpParser\Node\Scalar\LNumber(020000, [\Rector\NodeTypeResolver\Node\AttributeKey::KIND => \PhpParser\Node\Scalar\LNumber::KIND_OCT]), $bitwiseAnd);
        $ternary = new \PhpParser\Node\Expr\Ternary(new \PhpParser\Node\Expr\Variable(self::STAT), $identical, $this->nodeFactory->createFalse());
        $if->stmts[] = new \PhpParser\Node\Stmt\Return_($ternary);
        return $if;
    }
}
