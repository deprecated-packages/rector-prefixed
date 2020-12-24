<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node;
interface AttributeAwareNodeInterface extends \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Node
{
    public function setAttribute(string $name, $value) : void;
    public function getAttribute(string $name);
}
