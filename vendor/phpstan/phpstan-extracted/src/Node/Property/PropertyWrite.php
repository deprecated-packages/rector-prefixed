<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Node\Property;

use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
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
    public function __construct($fetch, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope)
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
    public function getScope() : \RectorPrefix20201227\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
