<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util;

use _PhpScoperb75b35f52b74\PhpParser\Comment\Doc;
use _PhpScoperb75b35f52b74\PhpParser\NodeAbstract;
use function assert;
use function is_string;
/**
 * @internal
 */
final class GetLastDocComment
{
    public static function forNode(\_PhpScoperb75b35f52b74\PhpParser\NodeAbstract $node) : string
    {
        $doc = null;
        foreach ($node->getComments() as $comment) {
            if (!$comment instanceof \_PhpScoperb75b35f52b74\PhpParser\Comment\Doc) {
                continue;
            }
            $doc = $comment;
        }
        if ($doc !== null) {
            $text = $doc->getReformattedText();
            \assert(\is_string($text));
            return $text;
        }
        return '';
    }
}