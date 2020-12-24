<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Contract\AttributeNodeAwareFactory;

use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
interface AttributeNodeAwareFactoryInterface
{
    public function getOriginalNodeClass() : string;
    public function isMatch(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node $node) : bool;
    public function create(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node $node, string $docContent) : \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
}
