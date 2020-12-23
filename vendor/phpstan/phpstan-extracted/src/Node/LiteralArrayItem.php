<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Node;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
class LiteralArrayItem
{
    /** @var Scope */
    private $scope;
    /** @var ArrayItem|null */
    private $arrayItem;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem $arrayItem)
    {
        $this->scope = $scope;
        $this->arrayItem = $arrayItem;
    }
    public function getScope() : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getArrayItem() : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem
    {
        return $this->arrayItem;
    }
}
