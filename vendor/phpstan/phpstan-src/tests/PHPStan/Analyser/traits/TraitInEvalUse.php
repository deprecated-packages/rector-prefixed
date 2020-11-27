<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\TraitErrors;

class TraitInEvalUse
{
    use \TraitInEval;
    public function doLorem() : void
    {
        $this->doFoo(1);
    }
}
