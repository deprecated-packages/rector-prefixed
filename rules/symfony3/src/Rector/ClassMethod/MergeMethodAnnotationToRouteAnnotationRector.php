<?php

declare (strict_types=1);
namespace Rector\Symfony3\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/routing.html#method-annotation
 * @see https://stackoverflow.com/questions/51171934/how-to-fix-symfony-3-4-route-and-method-deprecation
 *
 * @see \Rector\Symfony3\Tests\Rector\ClassMethod\MergeMethodAnnotationToRouteAnnotationRector\MergeMethodAnnotationToRouteAnnotationRectorTest
 */
final class MergeMethodAnnotationToRouteAnnotationRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Merge removed @Method annotation to @Route one', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/show/{id}")
     * @Method({"GET", "HEAD"})
     */
    public function show($id)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/show/{id}", methods={"GET","HEAD"})
     */
    public function show($id)
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike) {
            return null;
        }
        if (!$node->isPublic()) {
            return null;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        $sensioMethodTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode::class);
        if (!$sensioMethodTagValueNode instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode) {
            return null;
        }
        $methods = $sensioMethodTagValueNode->getMethods();
        $symfonyRouteTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode::class);
        if (!$symfonyRouteTagValueNode instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode) {
            return null;
        }
        $symfonyRouteTagValueNode->changeMethods($methods);
        $phpDocInfo->removeByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode::class);
        return $node;
    }
}
