<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Node\Property;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
class PropertyRead
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
    public function __construct($fetch, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope)
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
    public function getScope() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
