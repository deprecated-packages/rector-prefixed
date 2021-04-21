<?php

declare(strict_types=1);

namespace Rector\Symfony\NodeAnalyzer;

use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\MethodCall;

final class FormOptionsArrayMatcher
{
    /**
     * @return \PhpParser\Node\Expr\Array_|null
     */
    public function match(MethodCall $methodCall)
    {
        if (! isset($methodCall->args[2])) {
            return null;
        }

        $optionsArray = $methodCall->args[2]->value;
        if (! $optionsArray instanceof Array_) {
            return null;
        }

        return $optionsArray;
    }
}
