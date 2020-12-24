<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\RenamedNamespace;
final class NamespaceMatcher
{
    /**
     * @param string[] $oldToNewNamespace
     */
    public function matchRenamedNamespace(string $name, array $oldToNewNamespace) : ?\_PhpScopere8e811afab72\Rector\Core\ValueObject\RenamedNamespace
    {
        \krsort($oldToNewNamespace);
        /** @var string $oldNamespace */
        foreach ($oldToNewNamespace as $oldNamespace => $newNamespace) {
            if (\_PhpScopere8e811afab72\Nette\Utils\Strings::startsWith($name, $oldNamespace)) {
                return new \_PhpScopere8e811afab72\Rector\Core\ValueObject\RenamedNamespace($name, $oldNamespace, $newNamespace);
            }
        }
        return null;
    }
}
