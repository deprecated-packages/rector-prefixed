<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules;

class Ruleset
{
    /** @var Transformations */
    private $regular;
    /** @var Patterns */
    private $uninflected;
    /** @var Substitutions */
    private $irregular;
    public function __construct(\_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Transformations $regular, \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Patterns $uninflected, \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Substitutions $irregular)
    {
        $this->regular = $regular;
        $this->uninflected = $uninflected;
        $this->irregular = $irregular;
    }
    public function getRegular() : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Transformations
    {
        return $this->regular;
    }
    public function getUninflected() : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Patterns
    {
        return $this->uninflected;
    }
    public function getIrregular() : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Substitutions
    {
        return $this->irregular;
    }
}
