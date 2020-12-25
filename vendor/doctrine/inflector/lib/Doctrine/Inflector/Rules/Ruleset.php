<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules;

class Ruleset
{
    /** @var Transformations */
    private $regular;
    /** @var Patterns */
    private $uninflected;
    /** @var Substitutions */
    private $irregular;
    public function __construct(\_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformations $regular, \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Patterns $uninflected, \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitutions $irregular)
    {
        $this->regular = $regular;
        $this->uninflected = $uninflected;
        $this->irregular = $irregular;
    }
    public function getRegular() : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformations
    {
        return $this->regular;
    }
    public function getUninflected() : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Patterns
    {
        return $this->uninflected;
    }
    public function getIrregular() : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitutions
    {
        return $this->irregular;
    }
}
