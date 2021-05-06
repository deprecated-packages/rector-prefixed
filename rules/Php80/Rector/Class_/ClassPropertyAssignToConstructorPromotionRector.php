<?php

declare (strict_types=1);
namespace Rector\Php80\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\DeadCode\PhpDoc\TagRemover\VarTagRemover;
use Rector\Naming\VariableRenamer;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Php80\NodeResolver\PromotedPropertyResolver;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @changelog https://wiki.php.net/rfc/constructor_promotion https://github.com/php/php-src/pull/5291
 *
 * @see \Rector\Tests\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector\ClassPropertyAssignToConstructorPromotionRectorTest
 */
final class ClassPropertyAssignToConstructorPromotionRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var PromotedPropertyResolver
     */
    private $promotedPropertyResolver;
    /**
     * @var VariableRenamer
     */
    private $variableRenamer;
    /**
     * @var VarTagRemover
     */
    private $varTagRemover;
    public function __construct(\Rector\Php80\NodeResolver\PromotedPropertyResolver $promotedPropertyResolver, \Rector\Naming\VariableRenamer $variableRenamer, \Rector\DeadCode\PhpDoc\TagRemover\VarTagRemover $varTagRemover)
    {
        $this->promotedPropertyResolver = $promotedPropertyResolver;
        $this->variableRenamer = $variableRenamer;
        $this->varTagRemover = $varTagRemover;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change simple property init and assign to constructor promotion', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public float $someVariable;

    public function __construct(float $someVariable = 0.0)
    {
        $this->someVariable = $someVariable;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct(private float $someVariable = 0.0)
    {
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
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $promotionCandidates = $this->promotedPropertyResolver->resolveFromClass($node);
        if ($promotionCandidates === []) {
            return null;
        }
        /** @var ClassMethod $constructClassMethod */
        $constructClassMethod = $node->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $classMethodPhpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($constructClassMethod);
        foreach ($promotionCandidates as $promotionCandidate) {
            // does property have some useful annotations?
            $property = $promotionCandidate->getProperty();
            $param = $promotionCandidate->getParam();
            if ($param->variadic) {
                continue;
            }
            $this->removeNode($property);
            $this->removeNode($promotionCandidate->getAssign());
            $property = $promotionCandidate->getProperty();
            $paramName = $this->getName($param);
            // rename also following calls
            $propertyName = $this->getName($property->props[0]);
            /** @var string $oldName */
            $oldName = $this->getName($param->var);
            $this->variableRenamer->renameVariableInFunctionLike($constructClassMethod, null, $oldName, $propertyName);
            $paramTagValueNode = $classMethodPhpDocInfo->getParamTagValueNodeByName($paramName);
            if (!$paramTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode) {
                $this->decorateParamWithPropertyPhpDocInfo($property, $param);
            } elseif ($paramTagValueNode->parameterName !== '$' . $propertyName) {
                $paramTagValueNode->parameterName = '$' . $propertyName;
                $paramTagValueNode->setAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::ORIG_NODE, null);
            }
            // property name has higher priority
            $propertyName = $this->getName($property);
            $param->var->name = $propertyName;
            $param->flags = $property->flags;
            $this->processNullableType($property, $param);
        }
        return $node;
    }
    private function processNullableType(\PhpParser\Node\Stmt\Property $property, \PhpParser\Node\Param $param) : void
    {
        if ($this->nodeTypeResolver->isNullableType($property)) {
            $objectType = $this->getObjectType($property);
            $param->type = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($objectType);
        }
    }
    private function decorateParamWithPropertyPhpDocInfo(\PhpParser\Node\Stmt\Property $property, \PhpParser\Node\Param $param) : void
    {
        $propertyPhpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        $propertyPhpDocInfo->markAsChanged();
        $param->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $propertyPhpDocInfo);
        // make sure the docblock is useful
        if ($param->type === null) {
            return;
        }
        $paramType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
        $this->varTagRemover->removeVarPhpTagValueNodeIfNotComment($param, $paramType);
    }
}
