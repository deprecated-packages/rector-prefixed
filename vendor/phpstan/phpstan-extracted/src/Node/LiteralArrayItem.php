<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Node;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
class LiteralArrayItem
{
    /** @var Scope */
    private $scope;
    /** @var ArrayItem|null */
    private $arrayItem;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem $arrayItem)
    {
        $this->scope = $scope;
        $this->arrayItem = $arrayItem;
    }
    public function getScope() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getArrayItem() : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem
    {
        return $this->arrayItem;
    }
}
