<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactoryCollector;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
/**
 * @see \Rector\BetterPhpDocParser\Tests\Attributes\Ast\AttributeAwareNodeFactoryTest
 */
final class AttributeAwareNodeFactory
{
    /**
     * @var AttributeAwareNodeFactoryCollector
     */
    private $attributeAwareNodeFactoryCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\AttributeAwareNodeFactoryCollector $attributeAwareNodeFactoryCollector)
    {
        $this->attributeAwareNodeFactoryCollector = $attributeAwareNodeFactoryCollector;
    }
    /**
     * @return PhpDocNode|PhpDocChildNode|PhpDocTagValueNode|AttributeAwareNodeInterface
     */
    public function createFromNode(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        if ($node instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface) {
            return $node;
        }
        foreach ($this->attributeAwareNodeFactoryCollector->provide() as $attributeNodeAwareFactory) {
            if (!$attributeNodeAwareFactory->isMatch($node)) {
                continue;
            }
            // prevents cyclic dependency
            if ($attributeNodeAwareFactory instanceof \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory\AttributeAwareNodeFactoryAwareInterface) {
                $attributeNodeAwareFactory->setAttributeAwareNodeFactory($this);
            }
            return $attributeNodeAwareFactory->create($node, $docContent);
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException(\sprintf('Node "%s" was missed in "%s". Generate it with: bin/rector sync-types', \get_class($node), __METHOD__));
    }
}
