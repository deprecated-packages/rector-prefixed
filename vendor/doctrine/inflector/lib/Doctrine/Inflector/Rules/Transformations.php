<?php

declare (strict_types=1);
namespace RectorPrefix20210423\Doctrine\Inflector\Rules;

use RectorPrefix20210423\Doctrine\Inflector\WordInflector;
class Transformations implements \RectorPrefix20210423\Doctrine\Inflector\WordInflector
{
    /** @var Transformation[] */
    private $transformations;
    public function __construct(\RectorPrefix20210423\Doctrine\Inflector\Rules\Transformation ...$transformations)
    {
        $this->transformations = $transformations;
    }
    /**
     * @param string $word
     */
    public function inflect($word) : string
    {
        foreach ($this->transformations as $transformation) {
            if ($transformation->getPattern()->matches($word)) {
                return $transformation->inflect($word);
            }
        }
        return $word;
    }
}
