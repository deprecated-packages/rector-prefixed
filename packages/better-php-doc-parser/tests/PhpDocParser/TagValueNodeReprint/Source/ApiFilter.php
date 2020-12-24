<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source;

use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
/**
 * @Annotation
 * @Target({"PROPERTY", "CLASS"})
 */
class ApiFilter
{
    public function __construct($options = [])
    {
        if (!\class_exists($options['value'])) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
    }
}
