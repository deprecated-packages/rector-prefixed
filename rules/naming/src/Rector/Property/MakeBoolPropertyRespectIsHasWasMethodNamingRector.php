<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\Rector\Property;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\ExpectedNameResolver\BoolPropertyExpectedNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\PropertyRenamer\BoolPropertyRenamer;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\ValueObjectFactory\PropertyRenameFactory;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector\MakeBoolPropertyRespectIsHasWasMethodNamingRectorTest
 * @see \Rector\Naming\Tests\Rector\Property\MakeBoolPropertyRespectIsHasWasMethodNamingRector\Php74Test
 */
final class MakeBoolPropertyRespectIsHasWasMethodNamingRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\PropertyRenamer\BoolPropertyRenamer $boolPropertyRenamer, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\ValueObjectFactory\PropertyRenameFactory $propertyRenameFactory, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\ExpectedNameResolver\BoolPropertyExpectedNameResolver $boolPropertyExpectedNameResolver)
    {
        $this->propertyRenameFactory = $propertyRenameFactory;
        $this->boolPropertyRenamer = $boolPropertyRenamer;
        $this->boolPropertyExpectedNameResolver = $boolPropertyExpectedNameResolver;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Renames property to respect is/has/was method naming', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
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
