<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Rector\Property;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\BoolPropertyExpectedNameResolver;
use _PhpScoperb75b35f52b74\Rector\Naming\PropertyRenamer\BoolPropertyRenamer;
use _PhpScoperb75b35f52b74\Rector\Naming\ValueObjectFactory\PropertyRenameFactory;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector\MakeBoolPropertyRespectIsHasWasMethodNamingRectorTest
 * @see \Rector\Naming\Tests\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector\Php74Test
 */
final class MakeBoolPropertyRespectIsHasWasMethodNamingRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var PropertyRenameFactory
     */
    private $propertyRenameFactory;
    /**
     * @var BoolPropertyRenamer
     */
    private $boolPropertyRenamer;
    /**
     * @var BoolPropertyExpectedNameResolver
     */
    private $boolPropertyExpectedNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Naming\PropertyRenamer\BoolPropertyRenamer $boolPropertyRenamer, \_PhpScoperb75b35f52b74\Rector\Naming\ValueObjectFactory\PropertyRenameFactory $propertyRenameFactory, \_PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\BoolPropertyExpectedNameResolver $boolPropertyExpectedNameResolver)
    {
        $this->propertyRenameFactory = $propertyRenameFactory;
        $this->boolPropertyRenamer = $boolPropertyRenamer;
        $this->boolPropertyExpectedNameResolver = $boolPropertyExpectedNameResolver;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Renames property to respect is/has/was method naming', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    private $full = false;

    public function isFull()
    {
        return $this->full;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    private $isFull = false;

    public function isFull()
    {
        return $this->isFull;
    }

}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isPropertyBoolean($node)) {
            return null;
        }
        $propertyRename = $this->propertyRenameFactory->create($node, $this->boolPropertyExpectedNameResolver);
        if ($propertyRename === null) {
            return null;
        }
        $property = $this->boolPropertyRenamer->rename($propertyRename);
        //        dd($propertyRename->getClassLike());
        if ($property === null) {
            return null;
        }
        return $node;
    }
}
