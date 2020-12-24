<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

use _PhpScoperb75b35f52b74\PhpParser\Node;
class CommentHelper
{
    public static function getDocComment(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        $phpDoc = $node->getDocComment();
        if ($phpDoc !== null) {
            return $phpDoc->getText();
        }
        return null;
    }
}
