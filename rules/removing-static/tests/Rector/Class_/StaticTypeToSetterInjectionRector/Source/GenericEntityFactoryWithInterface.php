<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source;

use _PhpScoper5b8c9e9ebd21\phpDocumentor\Reflection\Types\Integer;
final class GenericEntityFactoryWithInterface
{
    public static function make() : \_PhpScoper5b8c9e9ebd21\phpDocumentor\Reflection\Types\Integer
    {
        return 5;
    }
}
