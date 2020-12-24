<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Node\Property;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
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
    public function __construct($fetch, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope)
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
    public function getScope() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
