<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\DependencyInjection\Type;

use _PhpScopere8e811afab72\PHPStan\Type\DynamicReturnTypeExtensionRegistry;
interface DynamicReturnTypeExtensionRegistryProvider
{
    public function getRegistry() : \_PhpScopere8e811afab72\PHPStan\Type\DynamicReturnTypeExtensionRegistry;
}
