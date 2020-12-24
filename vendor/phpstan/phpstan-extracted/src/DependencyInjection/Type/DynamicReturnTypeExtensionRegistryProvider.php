<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type;

use _PhpScoperb75b35f52b74\PHPStan\Type\DynamicReturnTypeExtensionRegistry;
interface DynamicReturnTypeExtensionRegistryProvider
{
    public function getRegistry() : \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicReturnTypeExtensionRegistry;
}
