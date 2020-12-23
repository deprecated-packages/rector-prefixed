<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory;

use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
interface AttributeNodeAwareFactoryInterface
{
    public function getOriginalNodeClass() : string;
    public function isMatch(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Node $node) : bool;
    public function create(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
}
