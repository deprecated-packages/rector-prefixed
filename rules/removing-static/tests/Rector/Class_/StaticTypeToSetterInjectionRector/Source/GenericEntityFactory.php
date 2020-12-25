<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source;

use _PhpScoper5edc98a7cce2\phpDocumentor\Reflection\Types\Integer;
final class GenericEntityFactory
{
    public static function make() : \_PhpScoper5edc98a7cce2\phpDocumentor\Reflection\Types\Integer
    {
        return 5;
    }
}
