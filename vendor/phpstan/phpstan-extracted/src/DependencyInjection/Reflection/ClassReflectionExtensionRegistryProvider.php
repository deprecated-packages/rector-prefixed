<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\DependencyInjection\Reflection;

use RectorPrefix20201227\PHPStan\Reflection\ClassReflectionExtensionRegistry;
interface ClassReflectionExtensionRegistryProvider
{
    public function getRegistry() : \RectorPrefix20201227\PHPStan\Reflection\ClassReflectionExtensionRegistry;
}
