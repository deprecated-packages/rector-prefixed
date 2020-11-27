<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Doctrine\Inflector\Rules;

class Ruleset
{
    /** @var Transformations */
    private $regular;
    /** @var Patterns */
    private $uninflected;
    /** @var Substitutions */
    private $irregular;
    public function __construct(\_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformations $regular, \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Patterns $uninflected, \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Substitutions $irregular)
    {
        $this->regular = $regular;
        $this->uninflected = $uninflected;
        $this->irregular = $irregular;
    }
    public function getRegular() : \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformations
    {
        return $this->regular;
    }
    public function getUninflected() : \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Patterns
    {
        return $this->uninflected;
    }
    public function getIrregular() : \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Substitutions
    {
        return $this->irregular;
    }
}
