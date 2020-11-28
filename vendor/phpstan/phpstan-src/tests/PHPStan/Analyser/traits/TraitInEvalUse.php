<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\TraitErrors;

class TraitInEvalUse
{
    use \TraitInEval;
    public function doLorem() : void
    {
        $this->doFoo(1);
    }
}
