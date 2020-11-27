<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\TraitErrors;

class TraitInEvalUse
{
    use \TraitInEval;
    public function doLorem() : void
    {
        $this->doFoo(1);
    }
}
