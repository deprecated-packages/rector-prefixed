<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\TraitErrors;

class TraitInEvalUse
{
    use \TraitInEval;
    public function doLorem() : void
    {
        $this->doFoo(1);
    }
}
