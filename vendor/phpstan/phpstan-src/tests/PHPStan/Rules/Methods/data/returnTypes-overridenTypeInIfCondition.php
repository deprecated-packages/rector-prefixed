<?php

namespace _PhpScoper26e51eeacccf\ReturnTypes;

class OverridenTypeInIfCondition
{
    public function getAnotherAnotherStock() : \_PhpScoper26e51eeacccf\ReturnTypes\Stock
    {
        $stock = new \_PhpScoper26e51eeacccf\ReturnTypes\Stock();
        if ($stock->findStock() === null) {
        }
        return $stock->findStock();
    }
}
