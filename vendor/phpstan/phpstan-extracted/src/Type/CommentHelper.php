<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
class CommentHelper
{
    public static function getDocComment(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?string
    {
        $phpDoc = $node->getDocComment();
        if ($phpDoc !== null) {
            return $phpDoc->getText();
        }
        return null;
    }
}
