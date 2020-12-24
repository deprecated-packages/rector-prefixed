<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Type;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicReturnTypeExtensionRegistry;
interface DynamicReturnTypeExtensionRegistryProvider
{
    public function getRegistry() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicReturnTypeExtensionRegistry;
}
