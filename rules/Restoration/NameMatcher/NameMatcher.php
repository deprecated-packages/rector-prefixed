<?php

declare(strict_types=1);

namespace Rector\Restoration\NameMatcher;

use Nette\Utils\Strings;
use Rector\Restoration\ClassMap\ExistingClassesProvider;

final class NameMatcher
{
    /**
     * @var ExistingClassesProvider
     */
    private $existingClassesProvider;

    public function __construct(ExistingClassesProvider $existingClassesProvider)
    {
        $this->existingClassesProvider = $existingClassesProvider;
    }

    /**
     * @return string|null
     */
    public function makeNameFullyQualified(string $shortName)
    {
        foreach ($this->existingClassesProvider->provide() as $declaredClass) {
            $declaredShortClass = (string) Strings::after($declaredClass, '\\', -1);
            if ($declaredShortClass !== $shortName) {
                continue;
            }

            return $declaredClass;
        }

        return null;
    }
}
