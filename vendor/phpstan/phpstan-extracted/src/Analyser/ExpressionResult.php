<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Analyser;

class ExpressionResult
{
    /** @var MutatingScope */
    private $scope;
    /** @var bool */
    private $hasYield;
    /** @var (callable(): MutatingScope)|null */
    private $truthyScopeCallback;
    /** @var MutatingScope|null */
    private $truthyScope = null;
    /** @var (callable(): MutatingScope)|null */
    private $falseyScopeCallback;
    /** @var MutatingScope|null */
    private $falseyScope = null;
    /**
     * @param MutatingScope $scope
     * @param bool $hasYield
     * @param (callable(): MutatingScope)|null $truthyScopeCallback
     * @param (callable(): MutatingScope)|null $falseyScopeCallback
     */
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Analyser\MutatingScope $scope, bool $hasYield, ?callable $truthyScopeCallback = null, ?callable $falseyScopeCallback = null)
    {
        $this->scope = $scope;
        $this->hasYield = $hasYield;
        $this->truthyScopeCallback = $truthyScopeCallback;
        $this->falseyScopeCallback = $falseyScopeCallback;
    }
    public function getScope() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\MutatingScope
    {
        return $this->scope;
    }
    public function hasYield() : bool
    {
        return $this->hasYield;
    }
    public function getTruthyScope() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\MutatingScope
    {
        if ($this->truthyScopeCallback === null) {
            return $this->scope;
        }
        if ($this->truthyScope !== null) {
            return $this->truthyScope;
        }
        $callback = $this->truthyScopeCallback;
        $this->truthyScope = $callback();
        return $this->truthyScope;
    }
    public function getFalseyScope() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\MutatingScope
    {
        if ($this->falseyScopeCallback === null) {
            return $this->scope;
        }
        if ($this->falseyScope !== null) {
            return $this->falseyScope;
        }
        $callback = $this->falseyScopeCallback;
        $this->falseyScope = $callback();
        return $this->falseyScope;
    }
}
