<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory;

use Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
interface AttributeAwareNodeFactoryAwareInterface
{
    /**
     * @param \Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory
     */
    public function setAttributeAwareNodeFactory($attributeAwareNodeFactory) : void;
}
