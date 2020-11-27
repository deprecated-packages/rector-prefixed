<?php

declare (strict_types=1);
namespace Rector\Php80\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Property;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\Php80\ValueObject\PromotionCandidate;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/constructor_promotion
 * @see https://github.com/php/php-src/pull/5291
 *
 * @see \Rector\Php80\Tests\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector\ClassPropertyAssignToConstructorPromotionRectorTest
 */
final class ClassPropertyAssignToConstructorPromotionRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var PromotionCandidate[]
     */
    private $promotionCandidates = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change simple property init and assign to constructor promotion', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public float $x;
    public float $y;
    public float $z;

    public function __construct(
        float $x = 0.0,
        float $y = 0.0,
        float $z = 0.0
    ) {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct(
        public float $x = 0.0,
        public float $y = 0.0,
        public float $z = 0.0,
    ) {}
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $promotionCandidates = $this->collectPromotionCandidatesFromClass($node);
        if ($promotionCandidates === []) {
            return null;
        }
        foreach ($this->promotionCandidates as $promotionCandidate) {
            $this->removeNode($promotionCandidate->getProperty());
            $this->removeNode($promotionCandidate->getAssign());
            $property = $promotionCandidate->getProperty();
            $param = $promotionCandidate->getParam();
            // property name has higher priority
            $param->var->name = $property->props[0]->name;
            // @todo add visibility - needs https://github.com/nikic/PHP-Parser/pull/667
            $param->flags = $property->flags;
        }
        return $node;
    }
    /**
     * @return PromotionCandidate[]
     */
    private function collectPromotionCandidatesFromClass(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $constructClassMethod = $class->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod === null) {
            return [];
        }
        $this->promotionCandidates = [];
        foreach ($class->getProperties() as $property) {
            if (\count($property->props) !== 1) {
                continue;
            }
            $this->collectPromotionCandidate($property, $constructClassMethod);
        }
        return $this->promotionCandidates;
    }
    private function collectPromotionCandidate(\PhpParser\Node\Stmt\Property $property, \PhpParser\Node\Stmt\ClassMethod $constructClassMethod) : void
    {
        $onlyProperty = $property->props[0];
        $propertyName = $this->getName($onlyProperty);
        // match property name to assign in constructor
        foreach ((array) $constructClassMethod->stmts as $stmt) {
            if ($stmt instanceof \PhpParser\Node\Stmt\Expression) {
                $stmt = $stmt->expr;
            }
            if (!$stmt instanceof \PhpParser\Node\Expr\Assign) {
                continue;
            }
            $assign = $stmt;
            if (!$this->isLocalPropertyFetchNamed($assign->var, $propertyName)) {
                continue;
            }
            // 1. is param
            // @todo 2. is default value
            $assignedExpr = $assign->expr;
            $matchedParam = $this->matchClassMethodParamByAssignedVariable($constructClassMethod, $assignedExpr);
            if ($matchedParam === null) {
                continue;
            }
            $this->promotionCandidates[] = new \Rector\Php80\ValueObject\PromotionCandidate($property, $assign, $matchedParam);
        }
    }
    private function matchClassMethodParamByAssignedVariable(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Expr $assignedExpr) : ?\PhpParser\Node\Param
    {
        foreach ($classMethod->params as $param) {
            if (!$this->areNodesEqual($assignedExpr, $param->var)) {
                continue;
            }
            return $param;
        }
        return null;
    }
}
