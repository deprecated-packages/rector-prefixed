<?php

declare (strict_types=1);
namespace Rector\Symfony\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTagRemover;
use Rector\BetterPhpDocParser\ValueObjectFactory\PhpDocNode\Symfony\SymfonyRouteTagValueNodeFactory;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://medium.com/@nebkam/symfony-deprecated-route-and-method-annotations-4d5e1d34556a
 * @see https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/routing.html#method-annotation
 *
 * @see \Rector\Symfony\Tests\Rector\ClassMethod\ReplaceSensioRouteAnnotationWithSymfonyRector\ReplaceSensioRouteAnnotationWithSymfonyRectorTest
 */
final class ReplaceSensioRouteAnnotationWithSymfonyRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var SymfonyRouteTagValueNodeFactory
     */
    private $symfonyRouteTagValueNodeFactory;
    /**
     * @var PhpDocTagRemover
     */
    private $phpDocTagRemover;
    public function __construct(\Rector\BetterPhpDocParser\ValueObjectFactory\PhpDocNode\Symfony\SymfonyRouteTagValueNodeFactory $symfonyRouteTagValueNodeFactory, \Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTagRemover $phpDocTagRemover)
    {
        $this->symfonyRouteTagValueNodeFactory = $symfonyRouteTagValueNodeFactory;
        $this->phpDocTagRemover = $phpDocTagRemover;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace Sensio @Route annotation with Symfony one', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

final class SomeClass
{
    /**
     * @Route()
     */
    public function run()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Routing\Annotation\Route;

final class SomeClass
{
    /**
     * @Route()
     */
    public function run()
    {
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class, \PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param ClassMethod|Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        if ($phpDocInfo->hasByAnnotationClass('Symfony\\Component\\Routing\\Annotation\\Route')) {
            return null;
        }
        $doctrineAnnotationTagValueNode = $phpDocInfo->getByAnnotationClass('Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Route');
        if (!$doctrineAnnotationTagValueNode instanceof \Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode) {
            return null;
        }
        $this->phpDocTagRemover->removeTagValueFromNode($phpDocInfo, $doctrineAnnotationTagValueNode);
        // unset service, that is deprecated
        $values = $doctrineAnnotationTagValueNode->getValues();
        $symfonyRouteTagValueNode = $this->symfonyRouteTagValueNodeFactory->createFromItems($values);
        $phpDocInfo->addTagValueNode($symfonyRouteTagValueNode);
        return $node;
    }
}
