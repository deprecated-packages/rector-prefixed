<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source;

use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
/**
 * @Annotation
 * @Target({"PROPERTY", "CLASS"})
 */
class ApiFilter
{
    public function __construct($options = [])
    {
        if (!\class_exists($options['value'])) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
    }
}
