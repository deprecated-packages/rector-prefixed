<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util;

use PhpParser\Comment\Doc;
use PhpParser\NodeAbstract;
use function assert;
use function is_string;
/**
 * @internal
 */
final class GetLastDocComment
{
    public static function forNode(\PhpParser\NodeAbstract $node) : string
    {
        $doc = null;
        foreach ($node->getComments() as $comment) {
            if (!$comment instanceof \PhpParser\Comment\Doc) {
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
