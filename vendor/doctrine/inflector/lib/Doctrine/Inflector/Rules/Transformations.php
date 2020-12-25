<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules;

use _PhpScoperbf340cb0be9d\Doctrine\Inflector\WordInflector;
class Transformations implements \_PhpScoperbf340cb0be9d\Doctrine\Inflector\WordInflector
{
    /** @var Transformation[] */
    private $transformations;
    public function __construct(\_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation ...$transformations)
    {
        $this->transformations = $transformations;
    }
    public function inflect(string $word) : string
    {
        foreach ($this->transformations as $transformation) {
            if ($transformation->getPattern()->matches($word)) {
                return $transformation->inflect($word);
            }
        }
        return $word;
    }
}
