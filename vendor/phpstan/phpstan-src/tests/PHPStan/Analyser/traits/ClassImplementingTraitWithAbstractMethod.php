<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\TraitErrors;

class ClassImplementingTraitWithAbstractMethod
{
    use TraitWithAbstractMethod;
    public function getTitle() : string
    {
        return 'foo';
    }
}
