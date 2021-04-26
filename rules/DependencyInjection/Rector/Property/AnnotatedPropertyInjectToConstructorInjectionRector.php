<?php

declare (strict_types=1);
namespace Rector\DependencyInjection\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PHPStan\Type\MixedType;
use Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTagRemover;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\DependencyInjection\NodeAnalyzer\NetteInjectPropertyAnalyzer;
use Rector\DependencyInjection\NodeManipulator\PropertyConstructorInjectionManipulator;
use Rector\FamilyTree\NodeAnalyzer\PropertyUsageAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Can cover these cases:
 * - https://doc.nette.org/en/2.4/di-usage#toc-inject-annotations
 * - https://github.com/Kdyby/Autowired/blob/master/docs/en/index.md#autowired-properties
 * - http://jmsyst.com/bundles/JMSDiExtraBundle/master/annotations
 * - https://github.com/rectorphp/rector/issues/700#issue-370301169
 * - https://jmsyst.com/bundles/JMSDiExtraBundle/master/annotations#inject
 *
 * @see \Rector\Tests\DependencyInjection\Rector\Property\AnnotatedPropertyInjectToConstructorInjectionRector\AnnotatedPropertyInjectToConstructorInjectionRectorTest
 */
final class AnnotatedPropertyInjectToConstructorInjectionRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const INJECT_ANNOTATION_CLASSES = ['DI\\Annotation\\Inject'];
    /**
     * @var PropertyUsageAnalyzer
     */
    private $propertyUsageAnalyzer;
    /**
     * @var NetteInjectPropertyAnalyzer
     */
    private $netteInjectPropertyAnalyzer;
    /**
     * @var PhpDocTagRemover
     */
    private $phpDocTagRemover;
    /**
     * @var PropertyConstructorInjectionManipulator
     */
    private $propertyConstructorInjectionManipulator;
    public function __construct(\Rector\FamilyTree\NodeAnalyzer\PropertyUsageAnalyzer $propertyUsageAnalyzer, \Rector\DependencyInjection\NodeAnalyzer\NetteInjectPropertyAnalyzer $netteInjectPropertyAnalyzer, \Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTagRemover $phpDocTagRemover, \Rector\DependencyInjection\NodeManipulator\PropertyConstructorInjectionManipulator $propertyConstructorInjectionManipulator)
    {
        $this->propertyUsageAnalyzer = $propertyUsageAnalyzer;
        $this->netteInjectPropertyAnalyzer = $netteInjectPropertyAnalyzer;
        $this->phpDocTagRemover = $phpDocTagRemover;
        $this->propertyConstructorInjectionManipulator = $propertyConstructorInjectionManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns properties with `@inject` to private properties and constructor injection', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return array<class-string<Node>>
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
        $phpDocInfo = $this->phpDocInfoFactory->createFromNode($node);
        if (!$phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return null;
        }
        if ($phpDocInfo->hasByName('inject')) {
            if ($this->netteInjectPropertyAnalyzer->canBeRefactored($node, $phpDocInfo)) {
                return $this->refactorNetteInjectProperty($phpDocInfo, $node);
            }
            // is not refactorable
            return null;
        }
        foreach (self::INJECT_ANNOTATION_CLASSES as $injectAnnotationClass) {
            $injectTagNode = $phpDocInfo->getByAnnotationClass($injectAnnotationClass);
            if (!$injectTagNode instanceof \Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode) {
                continue;
            }
            $serviceType = new \PHPStan\Type\MixedType();
            if ($injectTagNode !== null) {
                $serviceType = $phpDocInfo->getVarType();
            }
            if ($serviceType instanceof \PHPStan\Type\MixedType) {
                return null;
            }
            $this->propertyConstructorInjectionManipulator->refactor($node, $serviceType, $injectTagNode);
            if ($this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::PROPERTY_PROMOTION)) {
                $this->removeNode($node);
                return null;
            }
            return $node;
        }
        return null;
    }
    private function refactorNetteInjectProperty(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \PhpParser\Node\Stmt\Property $property) : ?\PhpParser\Node\Stmt\Property
    {
        $injectTagNode = $phpDocInfo->getByName('inject');
        if ($injectTagNode instanceof \PHPStan\PhpDocParser\Ast\Node) {
            $this->phpDocTagRemover->removeTagValueFromNode($phpDocInfo, $injectTagNode);
        }
        if ($this->propertyUsageAnalyzer->isPropertyFetchedInChildClass($property)) {
            $this->visibilityManipulator->makeProtected($property);
        } else {
            $this->visibilityManipulator->makePrivate($property);
        }
        $this->propertyAdder->addPropertyToCollector($property);
        if ($this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::PROPERTY_PROMOTION)) {
            $this->removeNode($property);
            return null;
        }
        return $property;
    }
}
