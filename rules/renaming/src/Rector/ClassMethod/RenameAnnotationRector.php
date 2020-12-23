<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\RenameAnnotation;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a2ac50786fa\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\ClassMethod\RenameAnnotationRector\RenameAnnotationRectorTest
 */
final class RenameAnnotationRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractPHPUnitRector implements \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const RENAMED_ANNOTATIONS_IN_TYPES = 'renamed_annotations_in_types';
    /**
     * @var RenameAnnotation[]
     */
    private $renamedAnnotationInTypes = [];
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined annotations above properties and methods to their new values.', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::RENAMED_ANNOTATIONS_IN_TYPES => [new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\RenameAnnotation('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'test', 'scenario')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param ClassMethod|Property $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        /** @var Class_ $classLike */
        $classLike = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
        \_PhpScoper0a2ac50786fa\Webmozart\Assert\Assert::allIsInstanceOf($renamedAnnotationsInTypes, \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\RenameAnnotation::class);
        $this->renamedAnnotationInTypes = $renamedAnnotationsInTypes;
    }
}
