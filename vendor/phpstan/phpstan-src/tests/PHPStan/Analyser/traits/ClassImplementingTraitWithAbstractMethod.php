<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\TraitErrors;

class ClassImplementingTraitWithAbstractMethod
{
    use TraitWithAbstractMethod;
    public function getTitle() : string
    {
        return 'foo';
    }
}
