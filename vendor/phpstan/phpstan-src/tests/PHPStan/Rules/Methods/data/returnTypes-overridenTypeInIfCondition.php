<?php

namespace _PhpScoper006a73f0e455\ReturnTypes;

class OverridenTypeInIfCondition
{
    public function getAnotherAnotherStock() : \_PhpScoper006a73f0e455\ReturnTypes\Stock
    {
        $stock = new \_PhpScoper006a73f0e455\ReturnTypes\Stock();
        if ($stock->findStock() === null) {
        }
        return $stock->findStock();
    }
}
