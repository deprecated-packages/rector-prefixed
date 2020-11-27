<?php

namespace _PhpScoper88fe6e0ad041\ReturnTypes;

class OverridenTypeInIfCondition
{
    public function getAnotherAnotherStock() : \_PhpScoper88fe6e0ad041\ReturnTypes\Stock
    {
        $stock = new \_PhpScoper88fe6e0ad041\ReturnTypes\Stock();
        if ($stock->findStock() === null) {
        }
        return $stock->findStock();
    }
}
