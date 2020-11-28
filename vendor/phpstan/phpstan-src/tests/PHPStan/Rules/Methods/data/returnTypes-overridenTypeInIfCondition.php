<?php

namespace _PhpScoperabd03f0baf05\ReturnTypes;

class OverridenTypeInIfCondition
{
    public function getAnotherAnotherStock() : \_PhpScoperabd03f0baf05\ReturnTypes\Stock
    {
        $stock = new \_PhpScoperabd03f0baf05\ReturnTypes\Stock();
        if ($stock->findStock() === null) {
        }
        return $stock->findStock();
    }
}
