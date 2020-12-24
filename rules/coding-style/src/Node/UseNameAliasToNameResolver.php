<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Node;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_;
use _PhpScopere8e811afab72\Rector\CodingStyle\ClassNameImport\ShortNameResolver;
use _PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScopere8e811afab72\Rector\CodingStyle\ClassNameImport\ShortNameResolver $shortNameResolver)
    {
        $this->shortNameResolver = $shortNameResolver;
        $this->classNaming = $classNaming;
    }
    /**
     * @return array<string, string[]>
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_ $use) : array
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
