<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php71\Rector\Assign;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Array_ as ArrayCast;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/ABDNv
 * @see https://stackoverflow.com/a/41000866/1348344
 * @see \Rector\Php71\Tests\Rector\Assign\AssignArrayToStringRector\AssignArrayToStringRectorTest
 */
final class AssignArrayToStringRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var PropertyProperty[]
     */
    private $emptyStringPropertyNodes = [];
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('String cannot be turned into array by assignment anymore', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        // only array with no explicit key assign, e.g. "$value[] = 5";
        if (!$node->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch) {
            return null;
        }
        if ($node->var->dim !== null) {
            return null;
        }
        $arrayDimFetchNode = $node->var;
        /** @var Variable|PropertyFetch|StaticPropertyFetch|Expr $variableNode */
        $variableNode = $arrayDimFetchNode->var;
        // set default value to property
        if (($variableNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch || $variableNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticPropertyFetch) && $this->processProperty($variableNode)) {
            return $node;
        }
        // fallback to variable, property or static property = '' set
        if ($this->processVariable($node, $variableNode)) {
            return $node;
        }
        // there is "$string[] = ...;", which would cause error in PHP 7+
        // fallback - if no array init found, retype to (array)
        $assign = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($arrayDimFetchNode->var, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Array_($arrayDimFetchNode->var));
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
        $this->traverseNodesWithCallable($nodes, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\PropertyProperty) {
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
    private function processProperty(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $propertyNode) : bool
    {
        foreach ($this->emptyStringPropertyNodes as $emptyStringPropertyNode) {
            if ($this->areNamesEqual($emptyStringPropertyNode, $propertyNode)) {
                $emptyStringPropertyNode->default = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_();
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param Variable|PropertyFetch|StaticPropertyFetch|Expr $expr
     */
    private function processVariable(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign $assign, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr) : bool
    {
        if ($this->shouldSkipVariable($expr)) {
            return \true;
        }
        $variableAssign = $this->betterNodeFinder->findFirstPrevious($assign, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($expr) : bool {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
                return \false;
            }
            if (!$this->areNodesEqual($node->var, $expr)) {
                return \false;
            }
            // we look for variable assign = string
            return $this->isEmptyStringNode($node->expr);
        });
        if ($variableAssign instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
            $variableAssign->expr = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_();
            return \true;
        }
        return \false;
    }
    private function isEmptyStringNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_) {
            return \false;
        }
        return $node->value === '';
    }
    private function shouldSkipVariable(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr) : bool
    {
        $staticType = $this->getStaticType($expr);
        if ($staticType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
            return \false;
        }
        if ($staticType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
            return !($staticType->isSuperTypeOf(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType()))->yes() && $staticType->isSuperTypeOf(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType(''))->yes());
        }
        return !$staticType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
    }
}
