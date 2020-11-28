<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\TraitErrors;

class ClassImplementingTraitWithAbstractMethod
{
    use TraitWithAbstractMethod;
    public function getTitle() : string
    {
        return 'foo';
    }
}
