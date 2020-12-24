<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Rector\ClassLike;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\ClassLike\RemoveAnnotationRector\RemoveAnnotationRectorTest
 */
final class RemoveAnnotationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const ANNOTATIONS_TO_REMOVE = 'annotations_to_remove';
    /**
     * @var mixed[]
     */
    private $annotationsToRemove = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove annotation by names', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
/**
 * @method getName()
 */
final class SomeClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
}
CODE_SAMPLE
, [self::ANNOTATIONS_TO_REMOVE => ['method']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike::class, \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst::class];
    }
    /**
     * @param ClassLike|FunctionLike|Property|ClassConst $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        foreach ($this->annotationsToRemove as $annotationToRemove) {
            if (!$phpDocInfo->hasByName($annotationToRemove)) {
                continue;
            }
            $phpDocInfo->removeByName($annotationToRemove);
        }
        return $node;
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $this->annotationsToRemove = $configuration[self::ANNOTATIONS_TO_REMOVE] ?? [];
    }
}
