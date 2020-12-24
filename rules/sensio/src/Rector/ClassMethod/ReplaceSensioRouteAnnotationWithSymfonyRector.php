<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Sensio\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://medium.com/@nebkam/symfony-deprecated-route-and-method-annotations-4d5e1d34556a
 * @see https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/routing.html#method-annotation
 *
 * @see \Rector\Sensio\Tests\Rector\ClassMethod\ReplaceSensioRouteAnnotationWithSymfonyRector\ReplaceSensioRouteAnnotationWithSymfonyRectorTest
 */
final class ReplaceSensioRouteAnnotationWithSymfonyRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace Sensio @Route annotation with Symfony one', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_::class];
    }
    /**
     * @param ClassMethod|Class_|Use_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_) {
            return $this->refactorUse($node);
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        if ($phpDocInfo->hasByType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode::class)) {
            return null;
        }
        /** @var SensioRouteTagValueNode|null $sensioRouteTagValueNode */
        $sensioRouteTagValueNode = $phpDocInfo->getByType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode::class);
        if ($sensioRouteTagValueNode === null) {
            return null;
        }
        /** @var SensioRouteTagValueNode $sensioRouteTagValueNode */
        $sensioRouteTagValueNode = $phpDocInfo->getByType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioRouteTagValueNode::class);
        $phpDocInfo->removeTagValueNodeFromNode($sensioRouteTagValueNode);
        // unset service, that is deprecated
        $items = $sensioRouteTagValueNode->getItems();
        $symfonyRouteTagValueNode = new \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode($items);
        $symfonyRouteTagValueNode->mimicTagValueNodeConfiguration($sensioRouteTagValueNode);
        $phpDocInfo->addTagValueNodeWithShortName($symfonyRouteTagValueNode);
        return $node;
    }
    private function refactorUse(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_ $use) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_
    {
        if ($use->type !== \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_::TYPE_NORMAL) {
            return null;
        }
        foreach ($use->uses as $useUse) {
            if (!$this->isName($useUse->name, '_PhpScoper0a6b37af0871\\Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Route')) {
                continue;
            }
            $useUse->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('_PhpScoper0a6b37af0871\\Symfony\\Component\\Routing\\Annotation\\Route');
        }
        return $use;
    }
}
