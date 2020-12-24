<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Printer;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode;
final class EmptyPhpDocDetector
{
    public function isPhpDocNodeEmpty(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode) : bool
    {
        if ($phpDocNode->children === []) {
            return \true;
        }
        foreach ($phpDocNode->children as $phpDocChildNode) {
            if ($phpDocChildNode instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode) {
                if ($phpDocChildNode->text !== '') {
                    return \false;
                }
            } else {
                return \false;
            }
        }
        return \true;
    }
}
