<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory;

use PHPStan\PhpDocParser\Ast\Node;
interface AttributeNodeAwareFactoryInterface
{
    public function isMatch(\PHPStan\PhpDocParser\Ast\Node $node) : bool;
    /**
     * @template T of Node
     * @param T $node
     * @return T
     */
    public function create(\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \PHPStan\PhpDocParser\Ast\Node;
}
