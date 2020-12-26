<?php

declare (strict_types=1);
namespace Rector\Naming;

use RectorPrefix2020DecSat\Doctrine\Inflector\Inflector;
use RectorPrefix2020DecSat\Nette\Utils\Strings;
final class RectorNamingInflector
{
    /**
     * @var string
     * @see https://regex101.com/r/VqVvke/3
     */
    private const DATA_INFO_SUFFIX_REGEX = '#^(?<prefix>.+)(?<suffix>Data|Info)$#';
    /**
     * @var Inflector
     */
    private $inflector;
    public function __construct(\RectorPrefix2020DecSat\Doctrine\Inflector\Inflector $inflector)
    {
        $this->inflector = $inflector;
    }
    public function singularize(string $name) : string
    {
        $matches = \RectorPrefix2020DecSat\Nette\Utils\Strings::match($name, self::DATA_INFO_SUFFIX_REGEX);
        if ($matches === null) {
            return $this->inflector->singularize($name);
        }
        $singularized = $this->inflector->singularize($matches['prefix']);
        $uninflectable = $matches['suffix'];
        return $singularized . $uninflectable;
    }
}
