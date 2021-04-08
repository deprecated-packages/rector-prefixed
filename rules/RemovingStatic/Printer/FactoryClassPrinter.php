<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Printer;

use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Namespace_;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem;
final class FactoryClassPrinter
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function printFactoryForClass(\PhpParser\Node\Stmt\Class_ $factoryClass, \PhpParser\Node\Stmt\Class_ $oldClass) : void
    {
        $parentNode = $oldClass->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \PhpParser\Node\Stmt\Namespace_) {
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
    private function createFactoryClassFilePath(\PhpParser\Node\Stmt\Class_ $oldClass) : string
    {
        $classFileInfo = $oldClass->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if (!$classFileInfo instanceof \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $directoryPath = \RectorPrefix20210408\Nette\Utils\Strings::before($classFileInfo->getRealPath(), \DIRECTORY_SEPARATOR, -1);
        $resolvedOldClass = $this->nodeNameResolver->getName($oldClass);
        if ($resolvedOldClass === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $bareClassName = \RectorPrefix20210408\Nette\Utils\Strings::after($resolvedOldClass, '\\', -1) . 'Factory.php';
        return $directoryPath . \DIRECTORY_SEPARATOR . $bareClassName;
    }
}
