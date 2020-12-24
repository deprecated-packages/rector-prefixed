<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Restoration\Rector\Use_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\Restoration\NameMatcher\FullyQualifiedNameMatcher;
use _PhpScoperb75b35f52b74\Rector\Restoration\NameMatcher\PhpDocTypeNodeNameMatcher;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Restoration\Tests\Rector\Use_\RestoreFullyQualifiedNameRector\RestoreFullyQualifiedNameRectorTest
 */
final class RestoreFullyQualifiedNameRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var FullyQualifiedNameMatcher
     */
    private $fullyQualifiedNameMatcher;
    /**
     * @var PhpDocTypeNodeNameMatcher
     */
    private $phpDocTypeNodeNameMatcher;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Restoration\NameMatcher\FullyQualifiedNameMatcher $fullyQualifiedNameMatcher, \_PhpScoperb75b35f52b74\Rector\Restoration\NameMatcher\PhpDocTypeNodeNameMatcher $phpDocTypeNodeNameMatcher)
    {
        $this->fullyQualifiedNameMatcher = $fullyQualifiedNameMatcher;
        $this->phpDocTypeNodeNameMatcher = $phpDocTypeNodeNameMatcher;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Restore accidentally shortened class names to its fully qualified form.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Param::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param Use_|Param|ClassMethod $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_) {
            return $this->refactoryUse($node);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Param) {
            return $this->refactorParam($node);
        }
        return $this->refactorClassMethod($node);
    }
    private function refactoryUse(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_ $use) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_
    {
        foreach ($use->uses as $useUse) {
            $name = $useUse->name;
            $fullyQualifiedName = $this->fullyQualifiedNameMatcher->matchFullyQualifiedName($name);
            if (!$fullyQualifiedName instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified) {
                continue;
            }
            $useUse->name = $fullyQualifiedName;
        }
        return $use;
    }
    private function refactorParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Param
    {
        $name = $param->type;
        if (!$name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            return null;
        }
        $fullyQualified = $this->fullyQualifiedNameMatcher->matchFullyQualifiedName($name);
        if ($fullyQualified === null) {
            return null;
        }
        $param->type = $fullyQualified;
        return $param;
    }
    private function refactorClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
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
    private function refactorReturnTagValueNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return;
        }
        $attributeAwareReturnTagValueNode = $phpDocInfo->getReturnTagValue();
        if ($attributeAwareReturnTagValueNode === null) {
            return;
        }
        if (!$phpDocInfo->getReturnType() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return;
        }
        if ($attributeAwareReturnTagValueNode->type instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            $fullyQualifiedTypeNode = $this->phpDocTypeNodeNameMatcher->matchIdentifier($attributeAwareReturnTagValueNode->type->name);
            if ($fullyQualifiedTypeNode === null) {
                return;
            }
            $attributeAwareReturnTagValueNode->type = $fullyQualifiedTypeNode;
        }
    }
}
