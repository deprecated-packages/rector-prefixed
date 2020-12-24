<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source;

use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
/**
 * @Annotation
 * @Target({"PROPERTY", "CLASS"})
 */
class ApiFilter
{
    public function __construct($options = [])
    {
        if (!\class_exists($options['value'])) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
    }
}
