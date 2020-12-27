<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Node;

use PhpParser\Node\Expr\ArrayItem;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
class LiteralArrayItem
{
    /** @var Scope */
    private $scope;
    /** @var ArrayItem|null */
    private $arrayItem;
    public function __construct(\RectorPrefix20201227\PHPStan\Analyser\Scope $scope, ?\PhpParser\Node\Expr\ArrayItem $arrayItem)
    {
        $this->scope = $scope;
        $this->arrayItem = $arrayItem;
    }
    public function getScope() : \RectorPrefix20201227\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getArrayItem() : ?\PhpParser\Node\Expr\ArrayItem
    {
        return $this->arrayItem;
    }
}
