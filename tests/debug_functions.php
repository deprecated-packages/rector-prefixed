<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use PhpParser\Node;
use PhpParser\PrettyPrinter\Standard;
require __DIR__ . '/../vendor/autoload.php';
/**
 * @param Node|Node[] $node
 */
function print_node($node) : void
{
    $standard = new \PhpParser\PrettyPrinter\Standard();
    if (\is_array($node)) {
        foreach ($node as $singleNode) {
            $printedContent = $standard->prettyPrint([$singleNode]);
            \_PhpScopera143bcca66cb\dump($printedContent);
        }
    } else {
        $printedContent = $standard->prettyPrint([$node]);
        \_PhpScopera143bcca66cb\dump($printedContent);
    }
}
