<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Attributes\Ast;

use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactoryCollector;
use Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use Rector\Core\Exception\ShouldNotHappenException;
/**
 * @see \Rector\BetterPhpDocParser\Tests\Attributes\Ast\AttributeAwareNodeFactoryTest
 */
final class AttributeAwareNodeFactory
{
    /**
     * @var AttributeAwareNodeFactoryCollector
     */
    private $attributeAwareNodeFactoryCollector;
    public function __construct(\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactoryCollector $attributeAwareNodeFactoryCollector)
    {
        $this->attributeAwareNodeFactoryCollector = $attributeAwareNodeFactoryCollector;
    }
    /**
     * @return PhpDocNode|PhpDocChildNode|PhpDocTagValueNode|AttributeAwareNodeInterface
     */
    public function createFromNode(\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        if ($node instanceof \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface) {
            return $node;
        }
        foreach ($this->attributeAwareNodeFactoryCollector->provide() as $attributeNodeAwareFactory) {
            if (!$attributeNodeAwareFactory->isMatch($node)) {
                continue;
            }
            // prevents cyclic dependency
            if ($attributeNodeAwareFactory instanceof \Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface) {
                $attributeNodeAwareFactory->setAttributeAwareNodeFactory($this);
            }
            return $attributeNodeAwareFactory->create($node, $docContent);
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException(\sprintf('Node "%s" was missed in "%s". Generate it with: bin/rector sync-types', \get_class($node), __METHOD__));
    }
}
