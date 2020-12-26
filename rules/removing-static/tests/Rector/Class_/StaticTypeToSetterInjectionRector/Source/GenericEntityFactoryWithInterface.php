<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source;

use RectorPrefix2020DecSat\phpDocumentor\Reflection\Types\Integer;
final class GenericEntityFactoryWithInterface
{
    public static function make() : \RectorPrefix2020DecSat\phpDocumentor\Reflection\Types\Integer
    {
        return 5;
    }
}
