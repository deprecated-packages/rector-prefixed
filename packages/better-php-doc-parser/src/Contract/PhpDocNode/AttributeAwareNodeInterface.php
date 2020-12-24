<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode;

use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Node;
interface AttributeAwareNodeInterface extends \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Node
{
    public function setAttribute(string $name, $value) : void;
    public function getAttribute(string $name);
}
