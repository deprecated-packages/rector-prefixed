<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php80\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\Naming\VariableRenamer;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\Php80\NodeResolver\PromotedPropertyResolver;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/constructor_promotion
 * @see https://github.com/php/php-src/pull/5291
 *
 * @see \Rector\Php80\Tests\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector\ClassPropertyAssignToConstructorPromotionRectorTest
 */
final class ClassPropertyAssignToConstructorPromotionRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var PromotedPropertyResolver
     */
    private $promotedPropertyResolver;
    /**
     * @var VariableRenamer
     */
    private $variableRenamer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Php80\NodeResolver\PromotedPropertyResolver $promotedPropertyResolver, \_PhpScoper0a6b37af0871\Rector\Naming\VariableRenamer $variableRenamer)
    {
        $this->promotedPropertyResolver = $promotedPropertyResolver;
        $this->variableRenamer = $variableRenamer;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change simple property init and assign to constructor promotion', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $promotionCandidates = $this->promotedPropertyResolver->resolveFromClass($node);
        if ($promotionCandidates === []) {
            return null;
        }
        /** @var ClassMethod $constructClassMethod */
        $constructClassMethod = $node->getMethod(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT);
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
    private function decorateParamWithPropertyPhpDocInfo(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property, \_PhpScoper0a6b37af0871\PhpParser\Node\Param $param) : void
    {
        $propertyPhpDocInfo = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$propertyPhpDocInfo instanceof \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return;
        }
        // make sure the docblock is useful
        $param->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $propertyPhpDocInfo);
    }
    private function removeClassMethodParam(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, string $paramName) : void
    {
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return;
        }
        $attributeAwareParamTagValueNode = $phpDocInfo->getParamTagValueByName($paramName);
        if ($attributeAwareParamTagValueNode === null) {
            return;
        }
        $phpDocInfo->removeTagValueNodeFromNode($attributeAwareParamTagValueNode);
    }
}
