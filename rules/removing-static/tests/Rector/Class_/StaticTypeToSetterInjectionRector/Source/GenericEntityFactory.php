<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source;

use _PhpScopere8e811afab72\phpDocumentor\Reflection\Types\Integer;
final class GenericEntityFactory
{
    public static function make() : \_PhpScopere8e811afab72\phpDocumentor\Reflection\Types\Integer
    {
        return 5;
    }
}
