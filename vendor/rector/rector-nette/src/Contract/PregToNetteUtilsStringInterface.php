<?php

declare(strict_types=1);

namespace Rector\Nette\Contract;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\StaticCall;

interface PregToNetteUtilsStringInterface
{
    /**
     * @return \PhpParser\Node\Expr\Cast\Bool_|null
     */
    public function refactorIdentical(Identical $identical);

    /**
     * @return \PhpParser\Node\Expr|null
     */
    public function refactorFuncCall(FuncCall $funcCall);
}
