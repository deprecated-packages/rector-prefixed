<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\JMS;

use _PhpScopere8e811afab72\JMS\DiExtraBundle\Annotation\Inject;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class JMSInjectPhpDocNodeFactory extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory\AbstractPhpDocNodeFactory implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\SpecificPhpDocNodeFactoryInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return string[]
     */
    public function getClasses() : array
    {
        return ['_PhpScopere8e811afab72\\JMS\\DiExtraBundle\\Annotation\\Inject'];
    }
    /**
     * @return JMSInjectTagValueNode|null
     */
    public function createFromNodeAndTokens(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator, string $annotationClass) : ?\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property) {
            return null;
        }
        /** @var Inject|null $inject */
        $inject = $this->nodeAnnotationReader->readPropertyAnnotation($node, $annotationClass);
        if ($inject === null) {
            return null;
        }
        $serviceName = $inject->value === null ? $this->nodeNameResolver->getName($node) : $inject->value;
        // needed for proper doc block formatting
        $annotationContent = $this->resolveContentFromTokenIterator($tokenIterator);
        $items = $this->annotationItemsResolver->resolve($inject);
        return new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\JMSInjectTagValueNode($items, $serviceName, $annotationContent);
    }
}
