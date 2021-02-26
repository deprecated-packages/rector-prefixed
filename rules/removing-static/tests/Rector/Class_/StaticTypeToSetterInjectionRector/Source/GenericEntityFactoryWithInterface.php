<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source;

use RectorPrefix20210226\phpDocumentor\Reflection\Types\Integer;
final class GenericEntityFactoryWithInterface
{
    public static function make() : \RectorPrefix20210226\phpDocumentor\Reflection\Types\Integer
    {
        return 5;
    }
}
