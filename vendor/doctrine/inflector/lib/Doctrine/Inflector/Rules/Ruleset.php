<?php

declare (strict_types=1);
namespace _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules;

class Ruleset
{
    /** @var Transformations */
    private $regular;
    /** @var Patterns */
    private $uninflected;
    /** @var Substitutions */
    private $irregular;
    public function __construct(\_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformations $regular, \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Patterns $uninflected, \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Substitutions $irregular)
    {
        $this->regular = $regular;
        $this->uninflected = $uninflected;
        $this->irregular = $irregular;
    }
    public function getRegular() : \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformations
    {
        return $this->regular;
    }
    public function getUninflected() : \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Patterns
    {
        return $this->uninflected;
    }
    public function getIrregular() : \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Substitutions
    {
        return $this->irregular;
    }
}
