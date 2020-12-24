<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Application;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Declare_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\UsedImportsResolver;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
final class UseImportsAdder
{
    /**
     * @var UsedImportsResolver
     */
    private $usedImportsResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\UsedImportsResolver $usedImportsResolver)
    {
        $this->usedImportsResolver = $usedImportsResolver;
    }
    /**
     * @param Stmt[] $stmts
     * @param FullyQualifiedObjectType[] $useImportTypes
     * @param FullyQualifiedObjectType[] $functionUseImportTypes
     * @return Stmt[]
     */
    public function addImportsToStmts(array $stmts, array $useImportTypes, array $functionUseImportTypes) : array
    {
        $existingUseImportTypes = $this->usedImportsResolver->resolveForStmts($stmts);
        $existingFunctionUseImports = $this->usedImportsResolver->resolveFunctionImportsForStmts($stmts);
        $useImportTypes = $this->diffFullyQualifiedObjectTypes($useImportTypes, $existingUseImportTypes);
        $functionUseImportTypes = $this->diffFullyQualifiedObjectTypes($functionUseImportTypes, $existingFunctionUseImports);
        $newUses = $this->createUses($useImportTypes, $functionUseImportTypes, null);
        // place after declare strict_types
        foreach ($stmts as $key => $stmt) {
            if ($stmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Declare_) {
                if (isset($stmts[$key + 1]) && $stmts[$key + 1] instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_) {
                    $nodesToAdd = $newUses;
                } else {
                    // add extra space, if there are no new use imports to be added
                    $nodesToAdd = \array_merge([new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop()], $newUses);
                }
                \array_splice($stmts, $key + 1, 0, $nodesToAdd);
                return $stmts;
            }
        }
        // make use stmts first
        return \array_merge($newUses, $stmts);
    }
    /**
     * @param FullyQualifiedObjectType[] $useImportTypes
     * @param FullyQualifiedObjectType[] $functionUseImportTypes
     */
    public function addImportsToNamespace(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_ $namespace, array $useImportTypes, array $functionUseImportTypes) : void
    {
        $namespaceName = $this->getNamespaceName($namespace);
        $existingUseImportTypes = $this->usedImportsResolver->resolveForNode($namespace);
        $existingFunctionUseImportTypes = $this->usedImportsResolver->resolveFunctionImportsForStmts($namespace->stmts);
        $useImportTypes = $this->diffFullyQualifiedObjectTypes($useImportTypes, $existingUseImportTypes);
        $functionUseImportTypes = $this->diffFullyQualifiedObjectTypes($functionUseImportTypes, $existingFunctionUseImportTypes);
        $newUses = $this->createUses($useImportTypes, $functionUseImportTypes, $namespaceName);
        $namespace->stmts = \array_merge($newUses, $namespace->stmts);
    }
    /**
     * @param FullyQualifiedObjectType[] $mainTypes
     * @param FullyQualifiedObjectType[] $typesToRemove
     * @return FullyQualifiedObjectType[]
     */
    private function diffFullyQualifiedObjectTypes(array $mainTypes, array $typesToRemove) : array
    {
        foreach ($mainTypes as $key => $mainType) {
            foreach ($typesToRemove as $typeToRemove) {
                if ($mainType->equals($typeToRemove)) {
                    unset($mainTypes[$key]);
                }
            }
        }
        return \array_values($mainTypes);
    }
    /**
     * @param AliasedObjectType[]|FullyQualifiedObjectType[] $useImportTypes
     * @param FullyQualifiedObjectType[] $functionUseImportTypes
     * @return Use_[]
     */
    private function createUses(array $useImportTypes, array $functionUseImportTypes, ?string $namespaceName) : array
    {
        $newUses = [];
        foreach ($useImportTypes as $useImportType) {
            if ($namespaceName !== null && $this->isCurrentNamespace($namespaceName, $useImportType)) {
                continue;
            }
            // already imported in previous cycle
            $newUses[] = $useImportType->getUseNode();
        }
        foreach ($functionUseImportTypes as $functionUseImportType) {
            if ($namespaceName !== null && $this->isCurrentNamespace($namespaceName, $functionUseImportType)) {
                continue;
            }
            // already imported in previous cycle
            $newUses[] = $functionUseImportType->getFunctionUseNode();
        }
        return $newUses;
    }
    private function getNamespaceName(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_ $namespace) : ?string
    {
        if ($namespace->name === null) {
            return null;
        }
        return $namespace->name->toString();
    }
    private function isCurrentNamespace(string $namespaceName, \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $objectType) : bool
    {
        $afterCurrentNamespace = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::after($objectType->getClassName(), $namespaceName . '\\');
        if (!$afterCurrentNamespace) {
            return \false;
        }
        return !\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($afterCurrentNamespace, '\\');
    }
}
