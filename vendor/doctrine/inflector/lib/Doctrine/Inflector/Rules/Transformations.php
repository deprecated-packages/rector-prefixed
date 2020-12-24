<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Doctrine\Inflector\Rules;

use _PhpScoper0a6b37af0871\Doctrine\Inflector\WordInflector;
class Transformations implements \_PhpScoper0a6b37af0871\Doctrine\Inflector\WordInflector
{
    /** @var Transformation[] */
    private $transformations;
    public function __construct(\_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Transformation ...$transformations)
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
