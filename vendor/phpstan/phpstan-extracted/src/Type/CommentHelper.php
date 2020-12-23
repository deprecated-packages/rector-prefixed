<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
class CommentHelper
{
    public static function getDocComment(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?string
    {
        $phpDoc = $node->getDocComment();
        if ($phpDoc !== null) {
            return $phpDoc->getText();
        }
        return null;
    }
}
