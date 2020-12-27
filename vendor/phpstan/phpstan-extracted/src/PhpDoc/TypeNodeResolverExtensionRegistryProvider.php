<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\PhpDoc;

interface TypeNodeResolverExtensionRegistryProvider
{
    public function getRegistry() : \RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry;
}
