<?php

declare(strict_types=1);

namespace Rector\DowngradePhp74\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ThisType;
use Rector\Core\Rector\AbstractRector;
use Rector\DowngradePhp71\TypeDeclaration\PhpDocFromTypeDeclarationDecorator;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\DowngradePhp74\Rector\ClassMethod\DowngradeSelfTypeDeclarationRector\DowngradeSelfTypeDeclarationRectorTest
 */
final class DowngradeSelfTypeDeclarationRector extends AbstractRector
{
    /**
     * @var PhpDocFromTypeDeclarationDecorator
     */
    private $phpDocFromTypeDeclarationDecorator;

    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;

    public function __construct(
        PhpDocFromTypeDeclarationDecorator $phpDocFromTypeDeclarationDecorator,
        ReflectionProvider $reflectionProvider
    ) {
        $this->phpDocFromTypeDeclarationDecorator = $phpDocFromTypeDeclarationDecorator;
        $this->reflectionProvider = $reflectionProvider;
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [ClassMethod::class];
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Remove "self" return type, add a "@return self" tag instead',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
class SomeClass
{
    public function foo(): self
    {
        return $this;
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
class SomeClass
{
    public function foo()
    {
        return $this;
    }
}
CODE_SAMPLE
                ),
            ]
        );
    }

    /**
     * @param ClassMethod $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        $scope = $node->getAttribute(AttributeKey::SCOPE);
        if ($scope === null) {
            // in a trait
            $className = $node->getAttribute(AttributeKey::CLASS_NAME);
            $classReflection = $this->reflectionProvider->getClass($className);
        } else {
            $classReflection = $scope->getClassReflection();
        }

        if (! $classReflection instanceof ClassReflection) {
            return null;
        }

        $thisType = new ThisType($classReflection);
        $this->phpDocFromTypeDeclarationDecorator->decorateReturnWithSpecificType($node, $thisType);

        return $node;
    }
}
