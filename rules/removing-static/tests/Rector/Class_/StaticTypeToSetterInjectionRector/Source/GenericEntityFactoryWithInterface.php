<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source;

use _PhpScoperb75b35f52b74\phpDocumentor\Reflection\Types\Integer;
final class GenericEntityFactoryWithInterface
{
    public static function make() : \_PhpScoperb75b35f52b74\phpDocumentor\Reflection\Types\Integer
    {
        return 5;
    }
}
