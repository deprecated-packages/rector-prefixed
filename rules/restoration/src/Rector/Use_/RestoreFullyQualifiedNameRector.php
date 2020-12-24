<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Restoration\Rector\Use_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\Restoration\NameMatcher\FullyQualifiedNameMatcher;
use _PhpScoper2a4e7ab1ecbc\Rector\Restoration\NameMatcher\PhpDocTypeNodeNameMatcher;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Restoration\Tests\Rector\Use_\RestoreFullyQualifiedNameRector\RestoreFullyQualifiedNameRectorTest
 */
final class RestoreFullyQualifiedNameRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var FullyQualifiedNameMatcher
     */
    private $fullyQualifiedNameMatcher;
    /**
     * @var PhpDocTypeNodeNameMatcher
     */
    private $phpDocTypeNodeNameMatcher;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Restoration\NameMatcher\FullyQualifiedNameMatcher $fullyQualifiedNameMatcher, \_PhpScoper2a4e7ab1ecbc\Rector\Restoration\NameMatcher\PhpDocTypeNodeNameMatcher $phpDocTypeNodeNameMatcher)
    {
        $this->fullyQualifiedNameMatcher = $fullyQualifiedNameMatcher;
        $this->phpDocTypeNodeNameMatcher = $phpDocTypeNodeNameMatcher;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Restore accidentally shortened class names to its fully qualified form.', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param Use_|Param|ClassMethod $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_) {
            return $this->refactoryUse($node);
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param) {
            return $this->refactorParam($node);
        }
        return $this->refactorClassMethod($node);
    }
    private function refactoryUse(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_ $use) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_
    {
        foreach ($use->uses as $useUse) {
            $name = $useUse->name;
            $fullyQualifiedName = $this->fullyQualifiedNameMatcher->matchFullyQualifiedName($name);
            if (!$fullyQualifiedName instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified) {
                continue;
            }
            $useUse->name = $fullyQualifiedName;
        }
        return $use;
    }
    private function refactorParam(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param
    {
        $name = $param->type;
        if (!$name instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name) {
            return null;
        }
        $fullyQualified = $this->fullyQualifiedNameMatcher->matchFullyQualifiedName($name);
        if ($fullyQualified === null) {
            return null;
        }
        $param->type = $fullyQualified;
        return $param;
    }
    private function refactorClassMethod(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod
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
    private function refactorReturnTagValueNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return;
        }
        $attributeAwareReturnTagValueNode = $phpDocInfo->getReturnTagValue();
        if ($attributeAwareReturnTagValueNode === null) {
            return;
        }
        if (!$phpDocInfo->getReturnType() instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
            return;
        }
        if ($attributeAwareReturnTagValueNode->type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            $fullyQualifiedTypeNode = $this->phpDocTypeNodeNameMatcher->matchIdentifier($attributeAwareReturnTagValueNode->type->name);
            if ($fullyQualifiedTypeNode === null) {
                return;
            }
            $attributeAwareReturnTagValueNode->type = $fullyQualifiedTypeNode;
        }
    }
}
