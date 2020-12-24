<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source;

use _PhpScoper2a4e7ab1ecbc\phpDocumentor\Reflection\Types\Integer;
final class GenericEntityFactory
{
    public static function make() : \_PhpScoper2a4e7ab1ecbc\phpDocumentor\Reflection\Types\Integer
    {
        return 5;
    }
}
