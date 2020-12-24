<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Restoration\Rector\Use_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\Restoration\NameMatcher\FullyQualifiedNameMatcher;
use _PhpScopere8e811afab72\Rector\Restoration\NameMatcher\PhpDocTypeNodeNameMatcher;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Restoration\Tests\Rector\Use_\RestoreFullyQualifiedNameRector\RestoreFullyQualifiedNameRectorTest
 */
final class RestoreFullyQualifiedNameRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var FullyQualifiedNameMatcher
     */
    private $fullyQualifiedNameMatcher;
    /**
     * @var PhpDocTypeNodeNameMatcher
     */
    private $phpDocTypeNodeNameMatcher;
    public function __construct(\_PhpScopere8e811afab72\Rector\Restoration\NameMatcher\FullyQualifiedNameMatcher $fullyQualifiedNameMatcher, \_PhpScopere8e811afab72\Rector\Restoration\NameMatcher\PhpDocTypeNodeNameMatcher $phpDocTypeNodeNameMatcher)
    {
        $this->fullyQualifiedNameMatcher = $fullyQualifiedNameMatcher;
        $this->phpDocTypeNodeNameMatcher = $phpDocTypeNodeNameMatcher;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Restore accidentally shortened class names to its fully qualified form.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use ShortClassOnly;

class AnotherClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use App\Whatever\ShortClassOnly;

class AnotherClass
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_::class, \_PhpScopere8e811afab72\PhpParser\Node\Param::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param Use_|Param|ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_) {
            return $this->refactoryUse($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Param) {
            return $this->refactorParam($node);
        }
        return $this->refactorClassMethod($node);
    }
    private function refactoryUse(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_ $use) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_
    {
        foreach ($use->uses as $useUse) {
            $name = $useUse->name;
            $fullyQualifiedName = $this->fullyQualifiedNameMatcher->matchFullyQualifiedName($name);
            if (!$fullyQualifiedName instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified) {
                continue;
            }
            $useUse->name = $fullyQualifiedName;
        }
        return $use;
    }
    private function refactorParam(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : ?\_PhpScopere8e811afab72\PhpParser\Node\Param
    {
        $name = $param->type;
        if (!$name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            return null;
        }
        $fullyQualified = $this->fullyQualifiedNameMatcher->matchFullyQualifiedName($name);
        if ($fullyQualified === null) {
            return null;
        }
        $param->type = $fullyQualified;
        return $param;
    }
    private function refactorClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $this->refactorReturnTagValueNode($classMethod);
        $returnType = $classMethod->returnType;
        if ($returnType === null) {
            return null;
        }
        $fullyQualified = $this->fullyQualifiedNameMatcher->matchFullyQualifiedName($returnType);
        if ($fullyQualified === null) {
            return null;
        }
        $classMethod->returnType = $fullyQualified;
        return $classMethod;
    }
    private function refactorReturnTagValueNode(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return;
        }
        $attributeAwareReturnTagValueNode = $phpDocInfo->getReturnTagValue();
        if ($attributeAwareReturnTagValueNode === null) {
            return;
        }
        if (!$phpDocInfo->getReturnType() instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return;
        }
        if ($attributeAwareReturnTagValueNode->type instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            $fullyQualifiedTypeNode = $this->phpDocTypeNodeNameMatcher->matchIdentifier($attributeAwareReturnTagValueNode->type->name);
            if ($fullyQualifiedTypeNode === null) {
                return;
            }
            $attributeAwareReturnTagValueNode->type = $fullyQualifiedTypeNode;
        }
    }
}
