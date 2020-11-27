<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules;

class Ruleset
{
    /** @var Transformations */
    private $regular;
    /** @var Patterns */
    private $uninflected;
    /** @var Substitutions */
    private $irregular;
    public function __construct(\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Transformations $regular, \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Patterns $uninflected, \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Substitutions $irregular)
    {
        $this->regular = $regular;
        $this->uninflected = $uninflected;
        $this->irregular = $irregular;
    }
    public function getRegular() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Transformations
    {
        return $this->regular;
    }
    public function getUninflected() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Patterns
    {
        return $this->uninflected;
    }
    public function getIrregular() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Substitutions
    {
        return $this->irregular;
    }
}
