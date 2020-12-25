<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source;

use _PhpScoper17db12703726\phpDocumentor\Reflection\Types\Integer;
final class GenericEntityFactoryWithInterface
{
    public static function make() : \_PhpScoper17db12703726\phpDocumentor\Reflection\Types\Integer
    {
        return 5;
    }
}
