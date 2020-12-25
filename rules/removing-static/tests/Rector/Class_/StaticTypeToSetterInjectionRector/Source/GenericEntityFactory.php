<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source;

use _PhpScoper8b9c402c5f32\phpDocumentor\Reflection\Types\Integer;
final class GenericEntityFactory
{
    public static function make() : \_PhpScoper8b9c402c5f32\phpDocumentor\Reflection\Types\Integer
    {
        return 5;
    }
}
