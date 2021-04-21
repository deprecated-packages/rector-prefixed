<?php

declare(strict_types=1);

namespace Rector\DowngradePhp74\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\DowngradePhp74\Rector\Property\DowngradeTypedPropertyRector\DowngradeTypedPropertyRectorTest
 */
final class DowngradeTypedPropertyRector extends AbstractRector
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
        return new RuleDefinition('Changes property type definition from type definitions to `@var` annotations.', [
            new CodeSample(
                <<<'CODE_SAMPLE'
class SomeClass
{
    private string $property;
}
CODE_SAMPLE
,
                <<<'CODE_SAMPLE'
class SomeClass
{
    /**
    * @var string
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
}
