<?php

declare (strict_types=1);
namespace Rector\Symfony\PhpDoc\NodeFactory\JMS;

use RectorPrefix20210327\JMS\DiExtraBundle\Annotation\Inject;
use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory;
use Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter;
use Rector\BetterPhpDocParser\Printer\TagValueNodePrinter;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\Symfony\PhpDoc\Node\JMS\JMSInjectTagValueNode;
final class JMSServiceInjectTagValueNodeFactory extends \Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ArrayPartPhpDocTagPrinter
     */
    private $arrayPartPhpDocTagPrinter;
    /**
     * @var TagValueNodePrinter
     */
    private $tagValueNodePrinter;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter $arrayPartPhpDocTagPrinter, \Rector\BetterPhpDocParser\Printer\TagValueNodePrinter $tagValueNodePrinter)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->arrayPartPhpDocTagPrinter = $arrayPartPhpDocTagPrinter;
        $this->tagValueNodePrinter = $tagValueNodePrinter;
    }
    /**
     * @return array<class-string>
     */
    public function getClasses() : array
    {
        return ['JMS\\DiExtraBundle\\Annotation\\Inject'];
    }
    /**
     * @return JMSInjectTagValueNode|null
     */
    public function createFromNodeAndTokens(\PhpParser\Node $node, \PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        if (!$node instanceof \PhpParser\Node\Stmt\Property) {
            return null;
        }
        $inject = $this->nodeAnnotationReader->readPropertyAnnotation($node, $annotationClass);
        if (!$inject instanceof \RectorPrefix20210327\JMS\DiExtraBundle\Annotation\Inject) {
            return null;
        }
        $serviceName = $inject->value === null ? $this->nodeNameResolver->getName($node) : $inject->value;
        // needed for proper doc block formatting
        $annotationContent = $this->resolveContentFromTokenIterator($tokenIterator);
        $items = $this->annotationItemsResolver->resolve($inject);
        return new \Rector\Symfony\PhpDoc\Node\JMS\JMSInjectTagValueNode($this->arrayPartPhpDocTagPrinter, $this->tagValueNodePrinter, $items, $serviceName, $annotationContent);
    }
}
