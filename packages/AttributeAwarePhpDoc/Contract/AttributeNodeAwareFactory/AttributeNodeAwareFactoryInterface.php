<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory;

use PHPStan\PhpDocParser\Ast\Node;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
interface AttributeNodeAwareFactoryInterface
{
    public function getOriginalNodeClass() : string;
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     */
    public function isMatch($node) : bool;
    /**
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @param string $docContent
     */
    public function create($node, $docContent) : \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
}
