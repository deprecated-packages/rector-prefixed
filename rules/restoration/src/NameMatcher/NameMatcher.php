<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Restoration\NameMatcher;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\Rector\Restoration\ClassMap\ExistingClassesProvider;
final class NameMatcher
{
    /**
     * @var ExistingClassesProvider
     */
    private $existingClassesProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Restoration\ClassMap\ExistingClassesProvider $existingClassesProvider)
    {
        $this->existingClassesProvider = $existingClassesProvider;
    }
    public function makeNameFullyQualified(string $shortName) : ?string
    {
        foreach ($this->existingClassesProvider->provide() as $declaredClass) {
            $declaredShortClass = (string) \_PhpScoper0a6b37af0871\Nette\Utils\Strings::after($declaredClass, '\\', -1);
            if ($declaredShortClass !== $shortName) {
                continue;
            }
            return $declaredClass;
        }
        return null;
    }
}
