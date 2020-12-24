<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PhpParser\Node;
class CommentHelper
{
    public static function getDocComment(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        $phpDoc = $node->getDocComment();
        if ($phpDoc !== null) {
            return $phpDoc->getText();
        }
        return null;
    }
}
