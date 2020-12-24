<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming;

use _PhpScoper0a6b37af0871\Doctrine\Inflector\Inflector;
use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
final class RectorNamingInflector
{
    /**
     * @var string
     * @see https://regex101.com/r/VqVvke/3
     */
    private const DATA_INFO_SUFFIX_REGEX = '#^(.+)(Data|Info)$#';
    /**
     * @var Inflector
     */
    private $inflector;
    public function __construct(\_PhpScoper0a6b37af0871\Doctrine\Inflector\Inflector $inflector)
    {
        $this->inflector = $inflector;
    }
    public function singularize(string $name) : string
    {
        $matches = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($name, self::DATA_INFO_SUFFIX_REGEX);
        if ($matches === null) {
            return $this->inflector->singularize($name);
        }
        $singularized = $this->inflector->singularize($matches[1]);
        $uninflectable = $matches[2];
        return $singularized . $uninflectable;
    }
}
