<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Restoration\NameMatcher;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Rector\Restoration\ClassMap\ExistingClassesProvider;
final class NameMatcher
{
    /**
     * @var ExistingClassesProvider
     */
    private $existingClassesProvider;
    public function __construct(\_PhpScopere8e811afab72\Rector\Restoration\ClassMap\ExistingClassesProvider $existingClassesProvider)
    {
        $this->existingClassesProvider = $existingClassesProvider;
    }
    public function makeNameFullyQualified(string $shortName) : ?string
    {
        foreach ($this->existingClassesProvider->provide() as $declaredClass) {
            $declaredShortClass = (string) \_PhpScopere8e811afab72\Nette\Utils\Strings::after($declaredClass, '\\', -1);
            if ($declaredShortClass !== $shortName) {
                continue;
            }
            return $declaredClass;
        }
        return null;
    }
}
