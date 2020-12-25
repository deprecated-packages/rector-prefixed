<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules;

use _PhpScoperbf340cb0be9d\Doctrine\Inflector\WordInflector;
use function strtolower;
use function strtoupper;
use function substr;
class Substitutions implements \_PhpScoperbf340cb0be9d\Doctrine\Inflector\WordInflector
{
    /** @var Substitution[] */
    private $substitutions;
    public function __construct(\_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitution ...$substitutions)
    {
        foreach ($substitutions as $substitution) {
            $this->substitutions[$substitution->getFrom()->getWord()] = $substitution;
        }
    }
    public function getFlippedSubstitutions() : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitutions
    {
        $substitutions = [];
        foreach ($this->substitutions as $substitution) {
            $substitutions[] = new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitution($substitution->getTo(), $substitution->getFrom());
        }
        return new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitutions(...$substitutions);
    }
    public function inflect(string $word) : string
    {
        $lowerWord = \strtolower($word);
        if (isset($this->substitutions[$lowerWord])) {
            $firstLetterUppercase = $lowerWord[0] !== $word[0];
            $toWord = $this->substitutions[$lowerWord]->getTo()->getWord();
            if ($firstLetterUppercase) {
                return \strtoupper($toWord[0]) . \substr($toWord, 1);
            }
            return $toWord;
        }
        return $word;
    }
}
