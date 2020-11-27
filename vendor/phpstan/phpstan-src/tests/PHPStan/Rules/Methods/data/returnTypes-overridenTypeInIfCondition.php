<?php

namespace _PhpScopera143bcca66cb\ReturnTypes;

class OverridenTypeInIfCondition
{
    public function getAnotherAnotherStock() : \_PhpScopera143bcca66cb\ReturnTypes\Stock
    {
        $stock = new \_PhpScopera143bcca66cb\ReturnTypes\Stock();
        if ($stock->findStock() === null) {
        }
        return $stock->findStock();
    }
}
