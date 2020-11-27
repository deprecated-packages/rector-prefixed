<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\TraitErrors;

class ClassImplementingTraitWithAbstractMethod
{
    use TraitWithAbstractMethod;
    public function getTitle() : string
    {
        return 'foo';
    }
}
