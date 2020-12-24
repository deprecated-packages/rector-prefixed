<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Node;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
class LiteralArrayItem
{
    /** @var Scope */
    private $scope;
    /** @var ArrayItem|null */
    private $arrayItem;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem $arrayItem)
    {
        $this->scope = $scope;
        $this->arrayItem = $arrayItem;
    }
    public function getScope() : \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getArrayItem() : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem
    {
        return $this->arrayItem;
    }
}
