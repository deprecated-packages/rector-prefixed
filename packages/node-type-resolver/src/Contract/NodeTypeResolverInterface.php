<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Contract;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
interface NodeTypeResolverInterface
{
    /**
     * @return class-string[]
     */
    public function getNodeClasses() : array;
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
}
