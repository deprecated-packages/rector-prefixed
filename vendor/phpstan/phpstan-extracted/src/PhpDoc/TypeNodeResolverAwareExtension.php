<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\PhpDoc;

interface TypeNodeResolverAwareExtension
{
    public function setTypeNodeResolver(\RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver) : void;
}
