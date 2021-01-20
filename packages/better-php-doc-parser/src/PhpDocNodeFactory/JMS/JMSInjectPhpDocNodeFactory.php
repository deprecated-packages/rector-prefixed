<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeFactory\JMS;

use RectorPrefix20210120\JMS\DiExtraBundle\Annotation\Inject;
use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface;
use Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode;
use Rector\NodeNameResolver\NodeNameResolver;
final class JMSInjectPhpDocNodeFactory extends \Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return string[]
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
        if (!$inject instanceof \RectorPrefix20210120\JMS\DiExtraBundle\Annotation\Inject) {
            return null;
        }
        $serviceName = $inject->value === null ? $this->nodeNameResolver->getName($node) : $inject->value;
        // needed for proper doc block formatting
        $annotationContent = $this->resolveContentFromTokenIterator($tokenIterator);
        $items = $this->annotationItemsResolver->resolve($inject);
        return new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode($items, $serviceName, $annotationContent);
    }
}
