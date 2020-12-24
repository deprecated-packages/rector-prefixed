<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Doctrine\Inflector\Rules;

class Ruleset
{
    /** @var Transformations */
    private $regular;
    /** @var Patterns */
    private $uninflected;
    /** @var Substitutions */
    private $irregular;
    public function __construct(\_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformations $regular, \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Patterns $uninflected, \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Substitutions $irregular)
    {
        $this->regular = $regular;
        $this->uninflected = $uninflected;
        $this->irregular = $irregular;
    }
    public function getRegular() : \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformations
    {
        return $this->regular;
    }
    public function getUninflected() : \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Patterns
    {
        return $this->uninflected;
    }
    public function getIrregular() : \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Substitutions
    {
        return $this->irregular;
    }
}
