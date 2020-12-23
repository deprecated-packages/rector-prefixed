<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Node\Property;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
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
    public function __construct($fetch, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope)
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
    public function getScope() : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
