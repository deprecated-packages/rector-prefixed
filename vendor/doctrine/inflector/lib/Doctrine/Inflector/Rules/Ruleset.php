<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat\Doctrine\Inflector\Rules;

class Ruleset
{
    /** @var Transformations */
    private $regular;
    /** @var Patterns */
    private $uninflected;
    /** @var Substitutions */
    private $irregular;
    public function __construct(\RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformations $regular, \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Patterns $uninflected, \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitutions $irregular)
    {
        $this->regular = $regular;
        $this->uninflected = $uninflected;
        $this->irregular = $irregular;
    }
    public function getRegular() : \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformations
    {
        return $this->regular;
    }
    public function getUninflected() : \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Patterns
    {
        return $this->uninflected;
    }
    public function getIrregular() : \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitutions
    {
        return $this->irregular;
    }
}
