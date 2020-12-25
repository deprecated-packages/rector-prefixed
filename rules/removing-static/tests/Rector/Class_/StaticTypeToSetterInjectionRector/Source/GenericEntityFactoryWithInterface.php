<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source;

use _PhpScoperf18a0c41e2d2\phpDocumentor\Reflection\Types\Integer;
final class GenericEntityFactoryWithInterface
{
    public static function make() : \_PhpScoperf18a0c41e2d2\phpDocumentor\Reflection\Types\Integer
    {
        return 5;
    }
}
