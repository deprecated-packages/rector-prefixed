<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Restoration\NameMatcher;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\Rector\Restoration\ClassMap\ExistingClassesProvider;
final class NameMatcher
{
    /**
     * @var ExistingClassesProvider
     */
    private $existingClassesProvider;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Restoration\ClassMap\ExistingClassesProvider $existingClassesProvider)
    {
        $this->existingClassesProvider = $existingClassesProvider;
    }
    public function makeNameFullyQualified(string $shortName) : ?string
    {
        foreach ($this->existingClassesProvider->provide() as $declaredClass) {
            $declaredShortClass = (string) \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::after($declaredClass, '\\', -1);
            if ($declaredShortClass !== $shortName) {
                continue;
            }
            return $declaredClass;
        }
        return null;
    }
}
