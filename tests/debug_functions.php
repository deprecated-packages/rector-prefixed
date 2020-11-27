<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

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
            \_PhpScoper88fe6e0ad041\dump($printedContent);
        }
    } else {
        $printedContent = $standard->prettyPrint([$node]);
        \_PhpScoper88fe6e0ad041\dump($printedContent);
    }
}
