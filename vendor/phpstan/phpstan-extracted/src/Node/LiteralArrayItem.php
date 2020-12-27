<?php

declare (strict_types=1);
namespace PHPStan\Node;

use PhpParser\Node\Expr\ArrayItem;
use PHPStan\Analyser\Scope;
class LiteralArrayItem
{
    /** @var Scope */
    private $scope;
    /** @var ArrayItem|null */
    private $arrayItem;
    public function __construct(\PHPStan\Analyser\Scope $scope, ?\PhpParser\Node\Expr\ArrayItem $arrayItem)
    {
        $this->scope = $scope;
        $this->arrayItem = $arrayItem;
    }
    public function getScope() : \PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getArrayItem() : ?\PhpParser\Node\Expr\ArrayItem
    {
        return $this->arrayItem;
    }
}
