<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Node;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_;
use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\ClassNameImport\ShortNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Naming\ClassNaming;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\ClassNameImport\ShortNameResolver $shortNameResolver)
    {
        $this->shortNameResolver = $shortNameResolver;
        $this->classNaming = $classNaming;
    }
    /**
     * @return array<string, string[]>
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_ $use) : array
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
