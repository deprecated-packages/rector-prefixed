<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source;

use _PhpScopera143bcca66cb\phpDocumentor\Reflection\Types\Integer;
final class GenericEntityFactoryWithInterface
{
    public static function make() : \_PhpScopera143bcca66cb\phpDocumentor\Reflection\Types\Integer
    {
        return 5;
    }
}
