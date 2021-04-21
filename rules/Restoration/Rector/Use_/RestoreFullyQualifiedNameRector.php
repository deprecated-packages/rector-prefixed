<?php

declare(strict_types=1);

namespace Rector\Restoration\Rector\Use_;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Use_;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\MixedType;
use Rector\Core\Rector\AbstractRector;
use Rector\Restoration\NameMatcher\FullyQualifiedNameMatcher;
use Rector\Restoration\NameMatcher\PhpDocTypeNodeNameMatcher;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\Restoration\Rector\Use_\RestoreFullyQualifiedNameRector\RestoreFullyQualifiedNameRectorTest
 */
final class RestoreFullyQualifiedNameRector extends AbstractRector
{
    /**
     * @var FullyQualifiedNameMatcher
     */
    private $fullyQualifiedNameMatcher;

    /**
     * @var PhpDocTypeNodeNameMatcher
     */
    private $phpDocTypeNodeNameMatcher;

    public function __construct(
        FullyQualifiedNameMatcher $fullyQualifiedNameMatcher,
        PhpDocTypeNodeNameMatcher $phpDocTypeNodeNameMatcher
    ) {
        $this->fullyQualifiedNameMatcher = $fullyQualifiedNameMatcher;
        $this->phpDocTypeNodeNameMatcher = $phpDocTypeNodeNameMatcher;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Restore accidentally shortened class names to its fully qualified form.',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
use ShortClassOnly;

class AnotherClass
{
}
CODE_SAMPLE

                    ,
                    <<<'CODE_SAMPLE'
use App\Whatever\ShortClassOnly;

class AnotherClass
{
}
CODE_SAMPLE

                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Use_::class, Param::class, ClassMethod::class];
    }

    /**
     * @param Use_|Param|ClassMethod $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if ($node instanceof Use_) {
            return $this->refactoryUse($node);
        }

        if ($node instanceof Param) {
            return $this->refactorParam($node);
        }

        return $this->refactorClassMethod($node);
    }

    private function refactoryUse(Use_ $use): Use_
    {
        foreach ($use->uses as $useUse) {
            $name = $useUse->name;

            $fullyQualifiedName = $this->fullyQualifiedNameMatcher->matchFullyQualifiedName($name);
            if (! $fullyQualifiedName instanceof FullyQualified) {
                continue;
            }

            $useUse->name = new Name($fullyQualifiedName->toString());
        }

        return $use;
    }

    /**
     * @return \PhpParser\Node\Param|null
     */
    private function refactorParam(Param $param)
    {
        $name = $param->type;
        if (! $name instanceof Name) {
            return null;
        }

        $fullyQualified = $this->fullyQualifiedNameMatcher->matchFullyQualifiedName($name);
        if ($fullyQualified === null) {
            return null;
        }

        $param->type = $fullyQualified;
        return $param;
    }

    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    private function refactorClassMethod(ClassMethod $classMethod)
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

    /**
     * @return void
     */
    private function refactorReturnTagValueNode(ClassMethod $classMethod)
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);

        $returnTagValueNode = $phpDocInfo->getReturnTagValue();
        if (! $returnTagValueNode instanceof ReturnTagValueNode) {
            return;
        }

        if (! $phpDocInfo->getReturnType() instanceof MixedType) {
            return;
        }

        if ($returnTagValueNode->type instanceof IdentifierTypeNode) {
            $fullyQualifiedTypeNode = $this->phpDocTypeNodeNameMatcher->matchIdentifier(
                $returnTagValueNode->type->name
            );
            if (! $fullyQualifiedTypeNode instanceof TypeNode) {
                return;
            }

            $returnTagValueNode->type = $fullyQualifiedTypeNode;
        }
    }
}
