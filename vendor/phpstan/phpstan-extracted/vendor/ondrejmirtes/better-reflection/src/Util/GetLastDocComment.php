<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util;

use _PhpScoper0a2ac50786fa\PhpParser\Comment\Doc;
use _PhpScoper0a2ac50786fa\PhpParser\NodeAbstract;
use function assert;
use function is_string;
/**
 * @internal
 */
final class GetLastDocComment
{
    public static function forNode(\_PhpScoper0a2ac50786fa\PhpParser\NodeAbstract $node) : string
    {
        $doc = null;
        foreach ($node->getComments() as $comment) {
            if (!$comment instanceof \_PhpScoper0a2ac50786fa\PhpParser\Comment\Doc) {
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
