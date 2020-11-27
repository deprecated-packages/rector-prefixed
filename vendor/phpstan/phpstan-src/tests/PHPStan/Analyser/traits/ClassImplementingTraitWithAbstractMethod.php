<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\TraitErrors;

class ClassImplementingTraitWithAbstractMethod
{
    use TraitWithAbstractMethod;
    public function getTitle() : string
    {
        return 'foo';
    }
}
