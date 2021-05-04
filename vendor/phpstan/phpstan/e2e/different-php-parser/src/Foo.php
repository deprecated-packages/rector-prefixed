<?php

namespace RectorPrefix20210504\App;

use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Catch_;
class Foo
{
    public function doFoo(\PhpParser\Node\Stmt\Catch_ $catch_) : void
    {
        $this->doBar($catch_->var);
    }
    public function doBar(\PhpParser\Node\Expr\Variable $var) : void
    {
    }
}
