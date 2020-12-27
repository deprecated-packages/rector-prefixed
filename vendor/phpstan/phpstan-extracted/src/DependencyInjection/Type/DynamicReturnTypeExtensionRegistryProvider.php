<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\DependencyInjection\Type;

use PHPStan\Type\DynamicReturnTypeExtensionRegistry;
interface DynamicReturnTypeExtensionRegistryProvider
{
    public function getRegistry() : \PHPStan\Type\DynamicReturnTypeExtensionRegistry;
}
