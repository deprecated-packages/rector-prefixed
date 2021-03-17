<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Contract\PhpDocNode;

use PHPStan\PhpDocParser\Ast\Node;
interface AttributeAwareNodeInterface extends \PHPStan\PhpDocParser\Ast\Node
{
    /**
     * @param string $name
     */
    public function setAttribute($name, $value) : void;
    /**
     * @param string $name
     */
    public function getAttribute($name);
}
