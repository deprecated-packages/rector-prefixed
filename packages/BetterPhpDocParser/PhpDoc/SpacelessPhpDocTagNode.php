<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDoc;

use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
/**
 * Useful for annotation class based annotation, e.g. @ORM\Entity to prevent space
 * between the @ORM\Entity and (someContent)
 */
final class SpacelessPhpDocTagNode extends \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode
{
    public function __toString() : string
    {
        return $this->name . $this->value;
    }
}
