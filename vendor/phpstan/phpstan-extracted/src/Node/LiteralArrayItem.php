<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Node;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
class LiteralArrayItem
{
    /** @var Scope */
    private $scope;
    /** @var ArrayItem|null */
    private $arrayItem;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope, ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem $arrayItem)
    {
        $this->scope = $scope;
        $this->arrayItem = $arrayItem;
    }
    public function getScope() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getArrayItem() : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem
    {
        return $this->arrayItem;
    }
}
