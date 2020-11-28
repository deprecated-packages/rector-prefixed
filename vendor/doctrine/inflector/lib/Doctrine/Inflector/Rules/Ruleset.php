<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules;

class Ruleset
{
    /** @var Transformations */
    private $regular;
    /** @var Patterns */
    private $uninflected;
    /** @var Substitutions */
    private $irregular;
    public function __construct(\_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformations $regular, \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Patterns $uninflected, \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitutions $irregular)
    {
        $this->regular = $regular;
        $this->uninflected = $uninflected;
        $this->irregular = $irregular;
    }
    public function getRegular() : \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformations
    {
        return $this->regular;
    }
    public function getUninflected() : \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Patterns
    {
        return $this->uninflected;
    }
    public function getIrregular() : \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitutions
    {
        return $this->irregular;
    }
}
