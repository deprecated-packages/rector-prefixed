<?php

declare (strict_types=1);
namespace Rector\Php71\Rector\Assign;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Cast\Array_ as ArrayCast;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\PropertyProperty;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\MixedType;
use PHPStan\Type\StringType;
use PHPStan\Type\UnionType;
use Rector\Core\Rector\AbstractRector;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/ABDNv
 * @see https://stackoverflow.com/a/41000866/1348344
 * @see \Rector\Php71\Tests\Rector\Assign\AssignArrayToStringRector\AssignArrayToStringRectorTest
 */
final class AssignArrayToStringRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var PropertyProperty[]
     */
    private $emptyStringPropertyNodes = [];
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('String cannot be turned into array by assignment anymore', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$string = '';
$string[] = 1;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$string = [];
$string[] = 1;
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        // only array with no explicit key assign, e.g. "$value[] = 5";
        if (!$node->var instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return null;
        }
        if ($node->var->dim !== null) {
            return null;
        }
        $arrayDimFetchNode = $node->var;
        /** @var Variable|PropertyFetch|StaticPropertyFetch|Expr $variableNode */
        $variableNode = $arrayDimFetchNode->var;
        // set default value to property
        if (($variableNode instanceof \PhpParser\Node\Expr\PropertyFetch || $variableNode instanceof \PhpParser\Node\Expr\StaticPropertyFetch) && $this->processProperty($variableNode)) {
            return $node;
        }
        // fallback to variable, property or static property = '' set
        if ($this->processVariable($node, $variableNode)) {
            return $node;
        }
        // there is "$string[] = ...;", which would cause error in PHP 7+
        // fallback - if no array init found, retype to (array)
        $assign = new \PhpParser\Node\Expr\Assign($arrayDimFetchNode->var, new \PhpParser\Node\Expr\Cast\Array_($arrayDimFetchNode->var));
        $this->addNodeAfterNode(clone $node, $node);
        return $assign;
    }
    /**
     * @param Node[] $nodes
     * @return Node[]|null
     */
    public function beforeTraverse(array $nodes) : ?array
    {
        // collect all known "{anything} = '';" assigns
        $this->traverseNodesWithCallable($nodes, function (\PhpParser\Node $node) : void {
            if (!$node instanceof \PhpParser\Node\Stmt\PropertyProperty) {
                return;
            }
            if ($node->default === null) {
                return;
            }
            if (!$this->isEmptyStringNode($node->default)) {
                return;
            }
            $this->emptyStringPropertyNodes[] = $node;
        });
        return $nodes;
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $propertyNode
     */
    private function processProperty(\PhpParser\Node $propertyNode) : bool
    {
        foreach ($this->emptyStringPropertyNodes as $emptyStringPropertyNode) {
            if ($this->areNamesEqual($emptyStringPropertyNode, $propertyNode)) {
                $emptyStringPropertyNode->default = new \PhpParser\Node\Expr\Array_();
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param Variable|PropertyFetch|StaticPropertyFetch|Expr $expr
     */
    private function processVariable(\PhpParser\Node\Expr\Assign $assign, \PhpParser\Node\Expr $expr) : bool
    {
        if ($this->shouldSkipVariable($expr)) {
            return \true;
        }
        $variableAssign = $this->betterNodeFinder->findFirstPrevious($assign, function (\PhpParser\Node $node) use($expr) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return \false;
            }
            if (!$this->areNodesEqual($node->var, $expr)) {
                return \false;
            }
            // we look for variable assign = string
            return $this->isEmptyStringNode($node->expr);
        });
        if ($variableAssign instanceof \PhpParser\Node\Expr\Assign) {
            $variableAssign->expr = new \PhpParser\Node\Expr\Array_();
            return \true;
        }
        return \false;
    }
    private function isEmptyStringNode(\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \PhpParser\Node\Scalar\String_) {
            return \false;
        }
        return $node->value === '';
    }
    private function shouldSkipVariable(\PhpParser\Node\Expr $expr) : bool
    {
        $staticType = $this->getStaticType($expr);
        if ($staticType instanceof \PHPStan\Type\ErrorType) {
            return \false;
        }
        if ($staticType instanceof \PHPStan\Type\UnionType) {
            return !($staticType->isSuperTypeOf(new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()))->yes() && $staticType->isSuperTypeOf(new \PHPStan\Type\Constant\ConstantStringType(''))->yes());
        }
        return !$staticType instanceof \PHPStan\Type\StringType;
    }
}
