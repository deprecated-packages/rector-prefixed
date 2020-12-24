<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameAnnotation;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\ClassMethod\RenameAnnotationRector\RenameAnnotationRectorTest
 */
final class RenameAnnotationRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractPHPUnitRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const RENAMED_ANNOTATIONS_IN_TYPES = 'renamed_annotations_in_types';
    /**
     * @var RenameAnnotation[]
     */
    private $renamedAnnotationInTypes = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined annotations above properties and methods to their new values.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::RENAMED_ANNOTATIONS_IN_TYPES => [new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameAnnotation('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'test', 'scenario')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param ClassMethod|Property $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        /** @var Class_ $classLike */
        $classLike = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($renamedAnnotationsInTypes, \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameAnnotation::class);
        $this->renamedAnnotationInTypes = $renamedAnnotationsInTypes;
    }
}
