<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\Naming\VariableRenamer;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\Php80\NodeResolver\PromotedPropertyResolver;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/constructor_promotion
 * @see https://github.com/php/php-src/pull/5291
 *
 * @see \Rector\Php80\Tests\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector\ClassPropertyAssignToConstructorPromotionRectorTest
 */
final class ClassPropertyAssignToConstructorPromotionRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var PromotedPropertyResolver
     */
    private $promotedPropertyResolver;
    /**
     * @var VariableRenamer
     */
    private $variableRenamer;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Php80\NodeResolver\PromotedPropertyResolver $promotedPropertyResolver, \_PhpScoperb75b35f52b74\Rector\Naming\VariableRenamer $variableRenamer)
    {
        $this->promotedPropertyResolver = $promotedPropertyResolver;
        $this->variableRenamer = $variableRenamer;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change simple property init and assign to constructor promotion', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $promotionCandidates = $this->promotedPropertyResolver->resolveFromClass($node);
        if ($promotionCandidates === []) {
            return null;
        }
        /** @var ClassMethod $constructClassMethod */
        $constructClassMethod = $node->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        foreach ($promotionCandidates as $promotionCandidate) {
            // does property have some useful annotations?
            $property = $promotionCandidate->getProperty();
            $this->removeNode($property);
            $this->removeNode($promotionCandidate->getAssign());
            $property = $promotionCandidate->getProperty();
            $param = $promotionCandidate->getParam();
            $this->decorateParamWithPropertyPhpDocInfo($property, $param);
            /** @var string $oldName */
            $oldName = $this->getName($param->var);
            // property name has higher priority
            $param->var->name = $property->props[0]->name;
            $param->flags = $property->flags;
            // rename also following calls
            $propertyName = $this->getName($property->props[0]);
            $this->variableRenamer->renameVariableInFunctionLike($constructClassMethod, null, $oldName, $propertyName);
            $this->removeClassMethodParam($constructClassMethod, $oldName);
        }
        return $node;
    }
    private function decorateParamWithPropertyPhpDocInfo(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : void
    {
        $propertyPhpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$propertyPhpDocInfo instanceof \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return;
        }
        // make sure the docblock is useful
        $param->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $propertyPhpDocInfo);
    }
    private function removeClassMethodParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, string $paramName) : void
    {
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return;
        }
        $attributeAwareParamTagValueNode = $phpDocInfo->getParamTagValueByName($paramName);
        if ($attributeAwareParamTagValueNode === null) {
            return;
        }
        $phpDocInfo->removeTagValueNodeFromNode($attributeAwareParamTagValueNode);
    }
}
