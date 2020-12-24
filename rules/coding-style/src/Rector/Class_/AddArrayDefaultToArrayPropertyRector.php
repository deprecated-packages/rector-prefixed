<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\TypeAnalyzer\IterableTypeAnalyzer;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\CodingStyle\Tests\Rector\Class_\AddArrayDefaultToArrayPropertyRector\AddArrayDefaultToArrayPropertyRectorTest
 * @see https://3v4l.org/dPlUg
 */
final class AddArrayDefaultToArrayPropertyRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var PropertyFetchManipulator
     */
    private $propertyFetchManipulator;
    /**
     * @var IterableTypeAnalyzer
     */
    private $iterableTypeAnalyzer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator $propertyFetchManipulator, \_PhpScoper0a6b37af0871\Rector\CodingStyle\TypeAnalyzer\IterableTypeAnalyzer $iterableTypeAnalyzer)
    {
        $this->propertyFetchManipulator = $propertyFetchManipulator;
        $this->iterableTypeAnalyzer = $iterableTypeAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds array default value to property to prevent foreach over null error', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var int[]
     */
    private $values;

    public function isEmpty()
    {
        return $this->values === null;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var int[]
     */
    private $values = [];

    public function isEmpty()
    {
        return $this->values === [];
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $changedProperties = $this->collectPropertyNamesWithMissingDefaultArray($node);
        if ($changedProperties === []) {
            return null;
        }
        $this->completeDefaultArrayToPropertyNames($node, $changedProperties);
        // $this->variable !== null && count($this->variable) > 0 → count($this->variable) > 0
        $this->clearNotNullBeforeCount($node, $changedProperties);
        // $this->variable === null → $this->variable === []
        $this->replaceNullComparisonOfArrayPropertiesWithArrayComparison($node, $changedProperties);
        return $node;
    }
    /**
     * @return string[]
     */
    private function collectPropertyNamesWithMissingDefaultArray(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $propertyNames = [];
        $this->traverseNodesWithCallable($class, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$propertyNames) {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty) {
                return null;
            }
            if ($node->default !== null) {
                return null;
            }
            $varType = $this->resolveVarType($node);
            if ($varType === null) {
                return null;
            }
            if (!$this->iterableTypeAnalyzer->detect($varType)) {
                return null;
            }
            $propertyNames[] = $this->getName($node);
            return null;
        });
        return $propertyNames;
    }
    /**
     * @param string[] $propertyNames
     */
    private function completeDefaultArrayToPropertyNames(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, array $propertyNames) : void
    {
        $this->traverseNodesWithCallable($class, function (\_PhpScoper0a6b37af0871\PhpParser\Node $class) use($propertyNames) : ?PropertyProperty {
            if (!$class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty) {
                return null;
            }
            if (!$this->isNames($class, $propertyNames)) {
                return null;
            }
            $class->default = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_();
            return $class;
        });
    }
    /**
     * @param string[] $propertyNames
     */
    private function clearNotNullBeforeCount(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, array $propertyNames) : void
    {
        $this->traverseNodesWithCallable($class, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($propertyNames) : ?Expr {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
                return null;
            }
            if (!$this->isLocalPropertyOfNamesNotIdenticalToNull($node->left, $propertyNames)) {
                return null;
            }
            $isNextNodeCountingProperty = (bool) $this->betterNodeFinder->findFirst($node->right, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($propertyNames) : ?bool {
                if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
                    return null;
                }
                if (!$this->isName($node, 'count')) {
                    return null;
                }
                if (!isset($node->args[0])) {
                    return null;
                }
                $countedArgument = $node->args[0]->value;
                if (!$countedArgument instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch) {
                    return null;
                }
                return $this->isNames($countedArgument, $propertyNames);
            });
            if (!$isNextNodeCountingProperty) {
                return null;
            }
            return $node->right;
        });
    }
    /**
     * @param string[] $propertyNames
     */
    private function replaceNullComparisonOfArrayPropertiesWithArrayComparison(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, array $propertyNames) : void
    {
        // replace comparison to "null" with "[]"
        $this->traverseNodesWithCallable($class, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($propertyNames) : ?BinaryOp {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp) {
                return null;
            }
            if ($this->propertyFetchManipulator->isLocalPropertyOfNames($node->left, $propertyNames) && $this->isNull($node->right)) {
                $node->right = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_();
            }
            if ($this->propertyFetchManipulator->isLocalPropertyOfNames($node->right, $propertyNames) && $this->isNull($node->left)) {
                $node->left = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_();
            }
            return $node;
        });
    }
    private function resolveVarType(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty $propertyProperty) : ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        /** @var Property $property */
        $property = $propertyProperty->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // we need docblock
        $propertyPhpDocInfo = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$propertyPhpDocInfo instanceof \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return null;
        }
        return $propertyPhpDocInfo->getVarType();
    }
    /**
     * @param string[] $propertyNames
     */
    private function isLocalPropertyOfNamesNotIdenticalToNull(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr, array $propertyNames) : bool
    {
        if (!$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return \false;
        }
        if ($this->propertyFetchManipulator->isLocalPropertyOfNames($expr->left, $propertyNames) && $this->isNull($expr->right)) {
            return \true;
        }
        if (!$this->propertyFetchManipulator->isLocalPropertyOfNames($expr->right, $propertyNames)) {
            return \false;
        }
        return $this->isNull($expr->left);
    }
}
