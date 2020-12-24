<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type;

use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class FullyQualifiedIdentifierTypeNode extends \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode implements \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
{
    use AttributeTrait;
    public function __toString() : string
    {
        return '\\' . $this->name;
    }
}
