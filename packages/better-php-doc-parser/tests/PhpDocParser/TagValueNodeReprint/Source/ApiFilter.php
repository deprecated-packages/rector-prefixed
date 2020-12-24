<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source;

use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
/**
 * @Annotation
 * @Target({"PROPERTY", "CLASS"})
 */
class ApiFilter
{
    public function __construct($options = [])
    {
        if (!\class_exists($options['value'])) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
    }
}
