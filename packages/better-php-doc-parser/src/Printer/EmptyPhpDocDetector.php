<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Printer;

use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode;
final class EmptyPhpDocDetector
{
    public function isPhpDocNodeEmpty(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode) : bool
    {
        if ($phpDocNode->children === []) {
            return \true;
        }
        foreach ($phpDocNode->children as $phpDocChildNode) {
            if ($phpDocChildNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode) {
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
