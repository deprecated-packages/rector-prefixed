<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Restoration\NameMatcher;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\Rector\Restoration\ClassMap\ExistingClassesProvider;
final class NameMatcher
{
    /**
     * @var ExistingClassesProvider
     */
    private $existingClassesProvider;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Restoration\ClassMap\ExistingClassesProvider $existingClassesProvider)
    {
        $this->existingClassesProvider = $existingClassesProvider;
    }
    public function makeNameFullyQualified(string $shortName) : ?string
    {
        foreach ($this->existingClassesProvider->provide() as $declaredClass) {
            $declaredShortClass = (string) \_PhpScoperb75b35f52b74\Nette\Utils\Strings::after($declaredClass, '\\', -1);
            if ($declaredShortClass !== $shortName) {
                continue;
            }
            return $declaredClass;
        }
        return null;
    }
}
