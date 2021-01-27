<?php

declare (strict_types=1);
namespace Rector\Renaming\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractPHPUnitRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockTagReplacer;
use Rector\Renaming\ValueObject\RenameAnnotation;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210127\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\ClassMethod\RenameAnnotationRector\RenameAnnotationRectorTest
 */
final class RenameAnnotationRector extends \Rector\Core\Rector\AbstractPHPUnitRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const RENAMED_ANNOTATIONS_IN_TYPES = 'renamed_annotations_in_types';
    /**
     * @var RenameAnnotation[]
     */
    private $renamedAnnotations = [];
    /**
     * @var DocBlockTagReplacer
     */
    private $docBlockTagReplacer;
    public function __construct(\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockTagReplacer $docBlockTagReplacer)
    {
        $this->docBlockTagReplacer = $docBlockTagReplacer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined annotations above properties and methods to their new values.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::RENAMED_ANNOTATIONS_IN_TYPES => [new \Rector\Renaming\ValueObject\RenameAnnotation('PHPUnit\\Framework\\TestCase', 'test', 'scenario')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class, \PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param ClassMethod|Property $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        foreach ($this->renamedAnnotations as $renamedAnnotationInType) {
            if (!$this->isObjectType($classLike, $renamedAnnotationInType->getType())) {
                continue;
            }
            $this->docBlockTagReplacer->replaceTagByAnother($phpDocInfo, $renamedAnnotationInType->getOldAnnotation(), $renamedAnnotationInType->getNewAnnotation());
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $renamedAnnotationsInTypes = $configuration[self::RENAMED_ANNOTATIONS_IN_TYPES] ?? [];
        \RectorPrefix20210127\Webmozart\Assert\Assert::allIsInstanceOf($renamedAnnotationsInTypes, \Rector\Renaming\ValueObject\RenameAnnotation::class);
        $this->renamedAnnotations = $renamedAnnotationsInTypes;
    }
}
