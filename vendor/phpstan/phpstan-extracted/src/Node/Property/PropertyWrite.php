<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Node\Property;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
class PropertyWrite
{
    /** @var PropertyFetch|StaticPropertyFetch */
    private $fetch;
    /** @var Scope */
    private $scope;
    /**
     * PropertyWrite constructor.
     *
     * @param PropertyFetch|StaticPropertyFetch $fetch
     * @param Scope $scope
     */
    public function __construct($fetch, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope)
    {
        $this->fetch = $fetch;
        $this->scope = $scope;
    }
    /**
     * @return PropertyFetch|StaticPropertyFetch
     */
    public function getFetch()
    {
        return $this->fetch;
    }
    public function getScope() : \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
