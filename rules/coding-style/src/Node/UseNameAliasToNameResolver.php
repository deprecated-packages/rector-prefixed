<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Node;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\ShortNameResolver;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming;
final class UseNameAliasToNameResolver
{
    /**
     * @var ShortNameResolver
     */
    private $shortNameResolver;
    /**
     * @var ClassNaming
     */
    private $classNaming;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\ShortNameResolver $shortNameResolver)
    {
        $this->shortNameResolver = $shortNameResolver;
        $this->classNaming = $classNaming;
    }
    /**
     * @return array<string, string[]>
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_ $use) : array
    {
        $useNamesAliasToName = [];
        $shortNames = $this->shortNameResolver->resolveForNode($use);
        foreach ($shortNames as $alias => $useImport) {
            if (!\is_string($alias)) {
                continue;
            }
            $shortName = $this->classNaming->getShortName($useImport);
            if ($shortName === $alias) {
                continue;
            }
            $useNamesAliasToName[$shortName][] = $alias;
        }
        return $useNamesAliasToName;
    }
}
