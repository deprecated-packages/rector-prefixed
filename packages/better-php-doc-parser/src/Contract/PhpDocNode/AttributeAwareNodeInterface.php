<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode;

use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node;
interface AttributeAwareNodeInterface extends \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node
{
    public function setAttribute(string $name, $value) : void;
    public function getAttribute(string $name);
}
