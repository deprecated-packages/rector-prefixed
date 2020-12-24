<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php71\Rector\FuncCall;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Instanceof_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Ternary;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Trait_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\Php71\NodeAnalyzer\CountableAnalyzer;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/Bndc9
 *
 * @see \Rector\Php71\Tests\Rector\FuncCall\CountOnNullRector\CountOnNullRectorTest
 */
final class CountOnNullRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const ALREADY_CHANGED_ON_COUNT = 'already_changed_on_count';
    /**
     * @var CountableAnalyzer
     */
    private $countableAnalyzer;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Php71\NodeAnalyzer\CountableAnalyzer $countableAnalyzer)
    {
        $this->countableAnalyzer = $countableAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes count() on null to safe ternary check', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$values = null;
$count = count($values);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$values = null;
$count = count((array) $values);
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $countedNode = $node->args[0]->value;
        if ($this->isCountableType($countedNode)) {
            return null;
        }
        // this can lead to false positive by phpstan, but that's best we can do
        $onlyValueType = $this->getStaticType($countedNode);
        if ($onlyValueType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
            if (!$this->countableAnalyzer->isCastableArrayType($countedNode)) {
                return null;
            }
            return $this->castToArray($countedNode, $node);
        }
        if ($this->isNullableArrayType($countedNode)) {
            return $this->castToArray($countedNode, $node);
        }
        if ($this->isNullableType($countedNode) || $this->isStaticType($countedNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType::class)) {
            $identical = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical($countedNode, $this->createNull());
            $ternary = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Ternary($identical, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber(0), $node);
            // prevent infinity loop re-resolution
            $node->setAttribute(self::ALREADY_CHANGED_ON_COUNT, \true);
            return $ternary;
        }
        if ($this->isAtLeastPhpVersion(\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\PhpVersionFeature::IS_COUNTABLE)) {
            $conditionNode = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('is_countable'), [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($countedNode)]);
        } else {
            $instanceof = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Instanceof_($countedNode, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified('Countable'));
            $conditionNode = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanOr($this->createFuncCall('is_array', [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($countedNode)]), $instanceof);
        }
        // prevent infinity loop re-resolution
        $node->setAttribute(self::ALREADY_CHANGED_ON_COUNT, \true);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Ternary($conditionNode, $node, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\LNumber(0));
    }
    private function shouldSkip(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall) : bool
    {
        if (!$this->isName($funcCall, 'count')) {
            return \true;
        }
        $alreadyChangedOnCount = $funcCall->getAttribute(self::ALREADY_CHANGED_ON_COUNT);
        // check if it has some condition before already, if so, probably it's already handled
        if ($alreadyChangedOnCount) {
            return \true;
        }
        $parentNode = $funcCall->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Ternary) {
            return \true;
        }
        if (!isset($funcCall->args[0])) {
            return \true;
        }
        // skip node in trait, as impossible to analyse
        $classLike = $funcCall->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        return $classLike instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Trait_;
    }
    private function castToArray(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $countedExpr, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall
    {
        $castArray = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Array_($countedExpr);
        $funcCall->args = [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($castArray)];
        return $funcCall;
    }
}
