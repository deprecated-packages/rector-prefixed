<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\TraitErrors;

class TraitInEvalUse
{
    use \TraitInEval;
    public function doLorem() : void
    {
        $this->doFoo(1);
    }
}
