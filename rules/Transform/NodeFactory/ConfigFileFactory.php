<?php

declare (strict_types=1);
namespace Rector\Transform\NodeFactory;

use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Testing\PhpConfigPrinter\PhpConfigPrinterFactory;
use RectorPrefix20210316\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
use RectorPrefix20210316\Symplify\SmartFileSystem\SmartFileInfo;
final class ConfigFileFactory
{
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    /**
     * @var SmartPhpConfigPrinter
     */
    private $smartPhpConfigPrinter;
    /**
     * @var RemovedAndAddedFilesCollector
     */
    private $removedAndAddedFilesCollector;
    public function __construct(\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \Rector\Testing\PhpConfigPrinter\PhpConfigPrinterFactory $phpConfigPrinterFactory, \Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector $removedAndAddedFilesCollector)
    {
        $this->valueResolver = $valueResolver;
        $this->smartPhpConfigPrinter = $phpConfigPrinterFactory->create();
        $this->removedAndAddedFilesCollector = $removedAndAddedFilesCollector;
    }
    public function createConfigFile(\PhpParser\Node\Stmt\ClassMethod $getRectorClassMethod) : void
    {
        $onlyStmt = $getRectorClassMethod->stmts[0] ?? null;
        if (!$onlyStmt instanceof \PhpParser\Node\Stmt\Return_) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        if (!$onlyStmt->expr instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $rectorClass = $this->valueResolver->getValue($onlyStmt->expr);
        if (!\is_string($rectorClass)) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $phpConfigFileContent = $this->smartPhpConfigPrinter->printConfiguredServices([$rectorClass => null]);
        $fileInfo = $getRectorClassMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if (!$fileInfo instanceof \RectorPrefix20210316\Symplify\SmartFileSystem\SmartFileInfo) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $configFilePath = \dirname($fileInfo->getRealPath()) . '/config/configured_rule.php';
        $addedFileWithContent = new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($configFilePath, $phpConfigFileContent);
        $this->removedAndAddedFilesCollector->addAddedFile($addedFileWithContent);
    }
}
