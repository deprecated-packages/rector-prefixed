<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\RenamedNamespace;
final class NamespaceMatcher
{
    /**
     * @param string[] $oldToNewNamespace
     */
    public function matchRenamedNamespace(string $name, array $oldToNewNamespace) : ?\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\RenamedNamespace
    {
        \krsort($oldToNewNamespace);
        /** @var string $oldNamespace */
        foreach ($oldToNewNamespace as $oldNamespace => $newNamespace) {
            if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::startsWith($name, $oldNamespace)) {
                return new \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\RenamedNamespace($name, $oldNamespace, $newNamespace);
            }
        }
        return null;
    }
}
