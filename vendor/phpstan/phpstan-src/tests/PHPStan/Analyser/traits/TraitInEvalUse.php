<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\TraitErrors;

class TraitInEvalUse
{
    use \TraitInEval;
    public function doLorem() : void
    {
        $this->doFoo(1);
    }
}
