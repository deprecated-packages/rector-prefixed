<?php

declare (strict_types=1);
namespace Rector\DowngradePhp74\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ThisType;
use Rector\Core\Rector\AbstractRector;
use Rector\DowngradePhp71\TypeDeclaration\PhpDocFromTypeDeclarationDecorator;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\DowngradePhp74\Rector\ClassMethod\DowngradeSelfTypeDeclarationRector\DowngradeSelfTypeDeclarationRectorTest
 */
final class DowngradeSelfTypeDeclarationRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var PhpDocFromTypeDeclarationDecorator
     */
    private $phpDocFromTypeDeclarationDecorator;
    public function __construct(\Rector\DowngradePhp71\TypeDeclaration\PhpDocFromTypeDeclarationDecorator $phpDocFromTypeDeclarationDecorator)
    {
        $this->phpDocFromTypeDeclarationDecorator = $phpDocFromTypeDeclarationDecorator;
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove "self" return type, add a "@return self" tag instead', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function foo(): self
    {
        return $this;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function foo()
    {
        return $this;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $this->phpDocFromTypeDeclarationDecorator->decorateReturnWithSpecificType($node, \PHPStan\Type\ThisType::class);
        return $node;
    }
}
