<?php

declare(strict_types=1);

namespace Rector\DowngradePhp80\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\UnionType;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\DowngradePhp80\Rector\Property\DowngradeUnionTypeTypedPropertyRector\DowngradeUnionTypeTypedPropertyRectorTest
 */
final class DowngradeUnionTypeTypedPropertyRector extends AbstractRector
{
    /**
     * @var PhpDocTypeChanger
     */
    private $phpDocTypeChanger;

    public function __construct(PhpDocTypeChanger $phpDocTypeChanger)
    {
        $this->phpDocTypeChanger = $phpDocTypeChanger;
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Property::class];
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Removes union type property type definition, adding `@var` annotations instead.', [
            new CodeSample(
                <<<'CODE_SAMPLE'
class SomeClass
{
    private string|int $property;
}
CODE_SAMPLE
,
                <<<'CODE_SAMPLE'
class SomeClass
{
    /**
    * @var string|int
    */
    private $property;
}
CODE_SAMPLE
            ),
        ]);
    }

    /**
     * @param Property $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if ($node->type === null) {
            return null;
        }

        if (! $this->shouldRemoveProperty($node)) {
            return null;
        }

        $this->decoratePropertyWithDocBlock($node, $node->type);
        $node->type = null;

        return $node;
    }

    /**
     * @return void
     */
    private function decoratePropertyWithDocBlock(Property $property, Node $typeNode)
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        if ($phpDocInfo->getVarTagValueNode() !== null) {
            return;
        }

        $newType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($typeNode);
        $this->phpDocTypeChanger->changeVarType($phpDocInfo, $newType);
    }

    private function shouldRemoveProperty(Property $property): bool
    {
        if ($property->type === null) {
            return false;
        }

        // Check it is the union type
        return $property->type instanceof UnionType;
    }
}
