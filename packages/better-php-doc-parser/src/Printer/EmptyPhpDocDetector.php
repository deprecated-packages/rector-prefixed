<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Printer;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode;
final class EmptyPhpDocDetector
{
    public function isPhpDocNodeEmpty(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode $phpDocNode) : bool
    {
        if ($phpDocNode->children === []) {
            return \true;
        }
        foreach ($phpDocNode->children as $phpDocChildNode) {
            if ($phpDocChildNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode) {
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
