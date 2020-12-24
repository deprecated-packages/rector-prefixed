<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RemovingStatic\Printer;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
final class FactoryClassPrinter
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function printFactoryForClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $factoryClass, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $oldClass) : void
    {
        $parentNode = $oldClass->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_) {
            $newNamespace = clone $parentNode;
            $newNamespace->stmts = [];
            $newNamespace->stmts[] = $factoryClass;
            $nodeToPrint = $newNamespace;
        } else {
            $nodeToPrint = $factoryClass;
        }
        $factoryClassFilePath = $this->createFactoryClassFilePath($oldClass);
        $factoryClassContent = $this->betterStandardPrinter->prettyPrintFile([$nodeToPrint]);
        $this->smartFileSystem->dumpFile($factoryClassFilePath, $factoryClassContent);
    }
    private function createFactoryClassFilePath(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $oldClass) : string
    {
        /** @var SmartFileInfo|null $classFileInfo */
        $classFileInfo = $oldClass->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($classFileInfo === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $directoryPath = \_PhpScopere8e811afab72\Nette\Utils\Strings::before($classFileInfo->getRealPath(), \DIRECTORY_SEPARATOR, -1);
        $resolvedOldClass = $this->nodeNameResolver->getName($oldClass);
        if ($resolvedOldClass === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $bareClassName = \_PhpScopere8e811afab72\Nette\Utils\Strings::after($resolvedOldClass, '\\', -1) . 'Factory.php';
        return $directoryPath . \DIRECTORY_SEPARATOR . $bareClassName;
    }
}
