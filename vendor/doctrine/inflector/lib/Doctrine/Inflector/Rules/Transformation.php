<?php

declare (strict_types=1);
namespace RectorPrefix20210317\Doctrine\Inflector\Rules;

use RectorPrefix20210317\Doctrine\Inflector\WordInflector;
use function preg_replace;
final class Transformation implements \RectorPrefix20210317\Doctrine\Inflector\WordInflector
{
    /** @var Pattern */
    private $pattern;
    /** @var string */
    private $replacement;
    /**
     * @param \Doctrine\Inflector\Rules\Pattern $pattern
     * @param string $replacement
     */
    public function __construct($pattern, $replacement)
    {
        $this->pattern = $pattern;
        $this->replacement = $replacement;
    }
    public function getPattern() : \RectorPrefix20210317\Doctrine\Inflector\Rules\Pattern
    {
        return $this->pattern;
    }
    public function getReplacement() : string
    {
        return $this->replacement;
    }
    public function inflect(string $word) : string
    {
        return (string) \preg_replace($this->pattern->getRegex(), $this->replacement, $word);
    }
}
