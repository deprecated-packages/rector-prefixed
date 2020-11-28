<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source;

use _PhpScoperabd03f0baf05\phpDocumentor\Reflection\Types\Integer;
final class GenericEntityFactory
{
    public static function make() : \_PhpScoperabd03f0baf05\phpDocumentor\Reflection\Types\Integer
    {
        return 5;
    }
}
