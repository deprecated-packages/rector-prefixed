<?php

declare(strict_types=1);

namespace Rector\Naming;

use Nette\Utils\Strings;
use Rector\Renaming\ValueObject\RenamedNamespace;

final class NamespaceMatcher
{
    /**
     * @param string[] $oldToNewNamespace
     * @return \Rector\Renaming\ValueObject\RenamedNamespace|null
     */
    public function matchRenamedNamespace(string $name, array $oldToNewNamespace)
    {
        krsort($oldToNewNamespace);

        /** @var string $oldNamespace */
        foreach ($oldToNewNamespace as $oldNamespace => $newNamespace) {
            if (Strings::startsWith($name, $oldNamespace)) {
                return new RenamedNamespace($name, $oldNamespace, $newNamespace);
            }
        }

        return null;
    }
}
