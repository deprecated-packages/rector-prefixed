<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Analyser;

interface TypeSpecifierAwareExtension
{
    public function setTypeSpecifier(\RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void;
}
