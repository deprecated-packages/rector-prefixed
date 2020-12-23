<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode;

use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Node;
interface AttributeAwareNodeInterface extends \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Node
{
    public function setAttribute(string $name, $value) : void;
    public function getAttribute(string $name);
}
