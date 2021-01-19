<?php

declare (strict_types=1);
namespace Rector\Generic\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTagRemover;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\FamilyTree\NodeAnalyzer\ClassChildAnalyzer;
use Rector\FamilyTree\NodeAnalyzer\PropertyUsageAnalyzer;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PhpAttribute\ValueObject\TagName;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Can cover these cases:
 * - https://doc.nette.org/en/2.4/di-usage#toc-inject-annotations
 * - https://github.com/Kdyby/Autowired/blob/master/docs/en/index.md#autowired-properties
 * - http://jmsyst.com/bundles/JMSDiExtraBundle/master/annotations
 * - https://github.com/rectorphp/rector/issues/700#issue-370301169
 *
 * @see \Rector\Generic\Tests\Rector\Property\AnnotatedPropertyInjectToConstructorInjectionRector\AnnotatedPropertyInjectToConstructorInjectionRectorTest
 */
final class AnnotatedPropertyInjectToConstructorInjectionRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var PropertyUsageAnalyzer
     */
    private $propertyUsageAnalyzer;
    /**
     * @var ClassChildAnalyzer
     */
    private $classChildAnalyzer;
    /**
     * @var PhpDocTagRemover
     */
    private $phpDocTagRemover;
    public function __construct(\Rector\FamilyTree\NodeAnalyzer\ClassChildAnalyzer $classChildAnalyzer, \Rector\FamilyTree\NodeAnalyzer\PropertyUsageAnalyzer $propertyUsageAnalyzer, \Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTagRemover $phpDocTagRemover)
    {
        $this->propertyUsageAnalyzer = $propertyUsageAnalyzer;
        $this->classChildAnalyzer = $classChildAnalyzer;
        $this->phpDocTagRemover = $phpDocTagRemover;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns non-private properties with `@annotation` to private properties and constructor injection', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
/**
 * @var SomeService
 * @inject
 */
public $someService;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
/**
 * @var SomeService
 */
private $someService;

public function __construct(SomeService $someService)
{
    $this->someService = $someService;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkipProperty($node)) {
            return null;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        $this->phpDocTagRemover->removeByName($phpDocInfo, \Rector\PhpAttribute\ValueObject\TagName::INJECT);
        if ($this->propertyUsageAnalyzer->isPropertyFetchedInChildClass($node)) {
            $this->makeProtected($node);
        } else {
            $this->makePrivate($node);
        }
        $this->addPropertyToCollector($node);
        if ($this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::PROPERTY_PROMOTION)) {
            $this->removeNode($node);
            return null;
        }
        return $node;
    }
    private function shouldSkipProperty(\PhpParser\Node\Stmt\Property $property) : bool
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        if (!$phpDocInfo->hasByName(\Rector\PhpAttribute\ValueObject\TagName::INJECT)) {
            return \true;
        }
        $classLike = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \true;
        }
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return \true;
        }
        if ($classLike->isAbstract()) {
            return \true;
        }
        if ($this->classChildAnalyzer->hasChildClassConstructor($classLike)) {
            return \true;
        }
        if ($this->classChildAnalyzer->hasParentClassConstructor($classLike)) {
            return \true;
        }
        // it needs @var tag as well, to get the type
        if ($phpDocInfo->getVarTagValueNode() !== null) {
            return \false;
        }
        return $property->type === null;
    }
}
