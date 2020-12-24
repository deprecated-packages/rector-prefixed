<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
class LiteralArrayItem
{
    /** @var Scope */
    private $scope;
    /** @var ArrayItem|null */
    private $arrayItem;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem $arrayItem)
    {
        $this->scope = $scope;
        $this->arrayItem = $arrayItem;
    }
    public function getScope() : \_PhpScopere8e811afab72\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getArrayItem() : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem
    {
        return $this->arrayItem;
    }
}
