<?php

declare (strict_types=1);
namespace PHPStan\PhpDoc;

interface TypeNodeResolverAwareExtension
{
    public function setTypeNodeResolver(\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver) : void;
}
