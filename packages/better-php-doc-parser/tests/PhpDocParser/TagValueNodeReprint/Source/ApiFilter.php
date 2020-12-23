<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source;

use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
/**
 * @Annotation
 * @Target({"PROPERTY", "CLASS"})
 */
class ApiFilter
{
    public function __construct($options = [])
    {
        if (!\class_exists($options['value'])) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
    }
}
