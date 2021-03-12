<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Contract\PhpDocNode;

use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
interface ClassNameAwareTagInterface extends \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    public function getClassName() : string;
}
