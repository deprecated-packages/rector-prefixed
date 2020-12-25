<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source;

use _PhpScoper567b66d83109\phpDocumentor\Reflection\Types\Integer;
final class GenericEntityFactory
{
    public static function make() : \_PhpScoper567b66d83109\phpDocumentor\Reflection\Types\Integer
    {
        return 5;
    }
}
