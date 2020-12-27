<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\DependencyInjection\Type;

use PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
interface OperatorTypeSpecifyingExtensionRegistryProvider
{
    public function getRegistry() : \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
}
