<?php

namespace _PhpScoperbd5d0c5f7638\ReturnTypes;

class OverridenTypeInIfCondition
{
    public function getAnotherAnotherStock() : \_PhpScoperbd5d0c5f7638\ReturnTypes\Stock
    {
        $stock = new \_PhpScoperbd5d0c5f7638\ReturnTypes\Stock();
        if ($stock->findStock() === null) {
        }
        return $stock->findStock();
    }
}
