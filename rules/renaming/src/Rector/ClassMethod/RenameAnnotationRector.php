<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameAnnotation;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\ClassMethod\RenameAnnotationRector\RenameAnnotationRectorTest
 */
final class RenameAnnotationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const RENAMED_ANNOTATIONS_IN_TYPES = 'renamed_annotations_in_types';
    /**
     * @var RenameAnnotation[]
     */
    private $renamedAnnotationInTypes = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined annotations above properties and methods to their new values.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeTest extends PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function someMethod()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeTest extends PHPUnit\Framework\TestCase
{
    /**
     * @scenario
     */
    public function someMethod()
    {
    }
}
CODE_SAMPLE
, [self::RENAMED_ANNOTATIONS_IN_TYPES => [new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameAnnotation('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'test', 'scenario')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param ClassMethod|Property $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        /** @var Class_ $classLike */
        $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        foreach ($this->renamedAnnotationInTypes as $renamedAnnotationInType) {
            if (!$this->isObjectType($classLike, $renamedAnnotationInType->getType())) {
                continue;
            }
            if (!$phpDocInfo->hasByName($renamedAnnotationInType->getOldAnnotation())) {
                continue;
            }
            $this->docBlockManipulator->replaceAnnotationInNode($node, $renamedAnnotationInType);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $renamedAnnotationsInTypes = $configuration[self::RENAMED_ANNOTATIONS_IN_TYPES] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($renamedAnnotationsInTypes, \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameAnnotation::class);
        $this->renamedAnnotationInTypes = $renamedAnnotationsInTypes;
    }
}
