<?php

declare (strict_types=1);
namespace Rector\Sensio\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Use_;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://medium.com/@nebkam/symfony-deprecated-route-and-method-annotations-4d5e1d34556a
 * @see https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/routing.html#method-annotation
 *
 * @see \Rector\Sensio\Tests\Rector\ClassMethod\ReplaceSensioRouteAnnotationWithSymfonyRector\ReplaceSensioRouteAnnotationWithSymfonyRectorTest
 */
final class ReplaceSensioRouteAnnotationWithSymfonyRector extends \Rector\Core\Rector\AbstractRector
{
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class, \PhpParser\Node\Stmt\Class_::class, \PhpParser\Node\Stmt\Use_::class];
    }
    /**
     * @param ClassMethod|Class_|Use_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Stmt\Use_) {
            return $this->refactorUse($node);
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        if ($phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode::class)) {
            return null;
        }
        $sensioRouteTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode::class);
        if (!$sensioRouteTagValueNode instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode) {
            return null;
        }
        $phpDocInfo->removeByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode::class);
        // unset service, that is deprecated
        $items = $sensioRouteTagValueNode->getItems();
        $symfonyRouteTagValueNode = new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode($items);
        $symfonyRouteTagValueNode->mimicTagValueNodeConfiguration($sensioRouteTagValueNode);
        $phpDocInfo->addTagValueNodeWithShortName($symfonyRouteTagValueNode);
        return $node;
    }
    private function refactorUse(\PhpParser\Node\Stmt\Use_ $use) : ?\PhpParser\Node\Stmt\Use_
    {
        if ($use->type !== \PhpParser\Node\Stmt\Use_::TYPE_NORMAL) {
            return null;
        }
        foreach ($use->uses as $useUse) {
            if (!$this->isName($useUse->name, 'Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Route')) {
                continue;
            }
            $useUse->name = new \PhpParser\Node\Name('Symfony\\Component\\Routing\\Annotation\\Route');
        }
        return $use;
    }
}
