<?php

declare (strict_types=1);
namespace Rector\Restoration\Rector\Use_;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Use_;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\MixedType;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareReturnTagValueNode;
use Rector\Core\Rector\AbstractRector;
use Rector\Restoration\NameMatcher\FullyQualifiedNameMatcher;
use Rector\Restoration\NameMatcher\PhpDocTypeNodeNameMatcher;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Restoration\Tests\Rector\Use_\RestoreFullyQualifiedNameRector\RestoreFullyQualifiedNameRectorTest
 */
final class RestoreFullyQualifiedNameRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var FullyQualifiedNameMatcher
     */
    private $fullyQualifiedNameMatcher;
    /**
     * @var PhpDocTypeNodeNameMatcher
     */
    private $phpDocTypeNodeNameMatcher;
    public function __construct(\Rector\Restoration\NameMatcher\FullyQualifiedNameMatcher $fullyQualifiedNameMatcher, \Rector\Restoration\NameMatcher\PhpDocTypeNodeNameMatcher $phpDocTypeNodeNameMatcher)
    {
        $this->fullyQualifiedNameMatcher = $fullyQualifiedNameMatcher;
        $this->phpDocTypeNodeNameMatcher = $phpDocTypeNodeNameMatcher;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Restore accidentally shortened class names to its fully qualified form.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Stmt\Use_::class, \PhpParser\Node\Param::class, \PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param Use_|Param|ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Stmt\Use_) {
            return $this->refactoryUse($node);
        }
        if ($node instanceof \PhpParser\Node\Param) {
            return $this->refactorParam($node);
        }
        return $this->refactorClassMethod($node);
    }
    private function refactoryUse(\PhpParser\Node\Stmt\Use_ $use) : \PhpParser\Node\Stmt\Use_
    {
        foreach ($use->uses as $useUse) {
            $name = $useUse->name;
            $fullyQualifiedName = $this->fullyQualifiedNameMatcher->matchFullyQualifiedName($name);
            if (!$fullyQualifiedName instanceof \PhpParser\Node\Name\FullyQualified) {
                continue;
            }
            $useUse->name = new \PhpParser\Node\Name($fullyQualifiedName->toString());
        }
        return $use;
    }
    private function refactorParam(\PhpParser\Node\Param $param) : ?\PhpParser\Node\Param
    {
        $name = $param->type;
        if (!$name instanceof \PhpParser\Node\Name) {
            return null;
        }
        $fullyQualified = $this->fullyQualifiedNameMatcher->matchFullyQualifiedName($name);
        if ($fullyQualified === null) {
            return null;
        }
        $param->type = $fullyQualified;
        return $param;
    }
    private function refactorClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Stmt\ClassMethod
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
    private function refactorReturnTagValueNode(\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        $attributeAwareReturnTagValueNode = $phpDocInfo->getReturnTagValue();
        if (!$attributeAwareReturnTagValueNode instanceof \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareReturnTagValueNode) {
            return;
        }
        if (!$phpDocInfo->getReturnType() instanceof \PHPStan\Type\MixedType) {
            return;
        }
        if ($attributeAwareReturnTagValueNode->type instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            $fullyQualifiedTypeNode = $this->phpDocTypeNodeNameMatcher->matchIdentifier($attributeAwareReturnTagValueNode->type->name);
            if (!$fullyQualifiedTypeNode instanceof \PHPStan\PhpDocParser\Ast\Type\TypeNode) {
                return;
            }
            $attributeAwareReturnTagValueNode->type = $fullyQualifiedTypeNode;
            $phpDocInfo->markAsChanged();
        }
    }
}
