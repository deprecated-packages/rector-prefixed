<?php

declare (strict_types=1);
namespace Rector\Symfony\PhpDoc\NodeFactory;

use Doctrine\ORM\Mapping\Annotation;
use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\Contract\MultiPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory;
use Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter;
use Rector\BetterPhpDocParser\Printer\TagValueNodePrinter;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
use Rector\Symfony\PhpDoc\Node\AssertChoiceTagValueNode;
use Rector\Symfony\PhpDoc\Node\AssertEmailTagValueNode;
use Rector\Symfony\PhpDoc\Node\AssertRangeTagValueNode;
use Rector\Symfony\PhpDoc\Node\AssertTypeTagValueNode;
use Rector\Symfony\PhpDoc\Node\SymfonyRouteTagValueNode;
final class MultiPhpDocNodeFactory extends \Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface, \Rector\BetterPhpDocParser\Contract\MultiPhpDocNodeFactoryInterface
{
    /**
     * @var ArrayPartPhpDocTagPrinter
     */
    private $arrayPartPhpDocTagPrinter;
    /**
     * @var TagValueNodePrinter
     */
    private $tagValueNodePrinter;
    public function __construct(\Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter $arrayPartPhpDocTagPrinter, \Rector\BetterPhpDocParser\Printer\TagValueNodePrinter $tagValueNodePrinter)
    {
        $this->arrayPartPhpDocTagPrinter = $arrayPartPhpDocTagPrinter;
        $this->tagValueNodePrinter = $tagValueNodePrinter;
    }
    /**
     * @return array<class-string<AbstractTagValueNode>, class-string<Annotation>>
     */
    public function getTagValueNodeClassesToAnnotationClasses() : array
    {
        return [
            // tag value node class => annotation class
            // symfony/http-kernel
            \Rector\Symfony\PhpDoc\Node\SymfonyRouteTagValueNode::class => 'Symfony\\Component\\Routing\\Annotation\\Route',
            // symfony/validator
            \Rector\Symfony\PhpDoc\Node\AssertRangeTagValueNode::class => 'Symfony\\Component\\Validator\\Constraints\\Range',
            \Rector\Symfony\PhpDoc\Node\AssertTypeTagValueNode::class => 'Symfony\\Component\\Validator\\Constraints\\Type',
            \Rector\Symfony\PhpDoc\Node\AssertChoiceTagValueNode::class => 'Symfony\\Component\\Validator\\Constraints\\Choice',
            \Rector\Symfony\PhpDoc\Node\AssertEmailTagValueNode::class => 'Symfony\\Component\\Validator\\Constraints\\Email',
        ];
    }
    public function createFromNodeAndTokens(\PhpParser\Node $node, \PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        $annotation = $this->nodeAnnotationReader->readAnnotation($node, $annotationClass);
        if ($annotation === null) {
            return null;
        }
        $tagValueNodeClassesToAnnotationClasses = $this->getTagValueNodeClassesToAnnotationClasses();
        $tagValueNodeClass = \array_search($annotationClass, $tagValueNodeClassesToAnnotationClasses, \true);
        if ($tagValueNodeClass === \false) {
            return null;
        }
        $items = $this->annotationItemsResolver->resolve($annotation);
        $content = $this->annotationContentResolver->resolveFromTokenIterator($tokenIterator);
        return new $tagValueNodeClass($this->arrayPartPhpDocTagPrinter, $this->tagValueNodePrinter, $items, $content);
    }
}
