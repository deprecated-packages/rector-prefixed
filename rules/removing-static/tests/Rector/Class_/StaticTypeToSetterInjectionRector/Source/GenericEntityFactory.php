<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source;

use RectorPrefix20210219\phpDocumentor\Reflection\Types\Integer;
final class GenericEntityFactory
{
    public static function make() : \RectorPrefix20210219\phpDocumentor\Reflection\Types\Integer
    {
        return 5;
    }
}
