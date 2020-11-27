<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\TraitErrors;

class ClassImplementingTraitWithAbstractMethod
{
    use TraitWithAbstractMethod;
    public function getTitle() : string
    {
        return 'foo';
    }
}
