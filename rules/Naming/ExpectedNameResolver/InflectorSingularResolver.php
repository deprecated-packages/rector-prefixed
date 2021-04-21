<?php

declare(strict_types=1);

namespace Rector\Naming\ExpectedNameResolver;

use Doctrine\Inflector\Inflector;
use Nette\Utils\Strings;

final class InflectorSingularResolver
{
    /**
     * @var array<string, string>
     */
    const SINGULAR_VERB = [
        'news' => 'new',
    ];

    /**
     * @var string
     * @see https://regex101.com/r/lbQaGC/1
     */
    const CAMELCASE_REGEX = '#(?<camelcase>([a-z]+|[A-Z]{1,}[a-z]+))#';

    /**
     * @var string
     * @see https://regex101.com/r/2aGdkZ/2
     */
    const BY_MIDDLE_REGEX = '#(?<by>By[A-Z][a-zA-Z]+)#';

    /**
     * @var string
     */
    const SINGLE = 'single';

    /**
     * @var Inflector
     */
    private $inflector;

    public function __construct(Inflector $inflector)
    {
        $this->inflector = $inflector;
    }

    public function resolve(string $currentName): string
    {
        $matchBy = Strings::match($currentName, self::BY_MIDDLE_REGEX);
        if ($matchBy) {
            return Strings::substring($currentName, 0, - strlen($matchBy['by']));
        }

        if (array_key_exists($currentName, self::SINGULAR_VERB)) {
            return self::SINGULAR_VERB[$currentName];
        }

        if (strpos($currentName, self::SINGLE) === 0) {
            return $currentName;
        }

        $camelCases = Strings::matchAll($currentName, self::CAMELCASE_REGEX);
        $singularValueVarName = '';
        foreach ($camelCases as $camelCase) {
            $singularValueVarName .= $this->inflector->singularize($camelCase['camelcase']);
        }

        if ($singularValueVarName === '') {
            return $currentName;
        }

        $singularValueVarName = $singularValueVarName === $currentName
            ? self::SINGLE . ucfirst($singularValueVarName)
            : $singularValueVarName;
        if (strpos($singularValueVarName, self::SINGLE) !== 0) {
            return $singularValueVarName;
        }
        $length = strlen($singularValueVarName);
        if ($length < 40) {
            return $singularValueVarName;
        }
        return $currentName;
    }
}
