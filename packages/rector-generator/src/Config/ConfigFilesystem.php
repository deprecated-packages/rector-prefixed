<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RectorGenerator\Config;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PhpParser\NodeVisitor\NameResolver;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Parser\Parser;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector;
use _PhpScopere8e811afab72\Rector\RectorGenerator\TemplateFactory;
use _PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
final class ConfigFilesystem
{
    /**
     * @var string
     */
    public const RECTOR_FQN_NAME_PATTERN = '_PhpScopere8e811afab72\\Rector\\__Package__\\Rector\\__Category__\\__Name__';
    /**
     * @var TemplateFactory
     */
    private $templateFactory;
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var AddNewServiceToSymfonyPhpConfigRector
     */
    private $addNewServiceToSymfonyPhpConfigRector;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\_PhpScopere8e811afab72\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector $addNewServiceToSymfonyPhpConfigRector, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Parser\Parser $parser, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScopere8e811afab72\Rector\RectorGenerator\TemplateFactory $templateFactory)
    {
        $this->templateFactory = $templateFactory;
        $this->parser = $parser;
        $this->addNewServiceToSymfonyPhpConfigRector = $addNewServiceToSymfonyPhpConfigRector;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @param string[] $templateVariables
     */
    public function appendRectorServiceToSet(\_PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe, array $templateVariables) : void
    {
        if ($rectorRecipe->getSet() === null) {
            return;
        }
        $setFilePath = $rectorRecipe->getSet();
        $setFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($setFilePath);
        $setFileContents = $setFileInfo->getContents();
        // already added?
        $rectorFqnName = $this->templateFactory->create(self::RECTOR_FQN_NAME_PATTERN, $templateVariables);
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($setFileContents, $rectorFqnName)) {
            return;
        }
        // 1. parse the file
        $setConfigNodes = $this->parser->parseFileInfo($setFileInfo);
        // 2. add the set() call
        $this->decorateNamesToFullyQualified($setConfigNodes);
        $nodeTraverser = new \_PhpScopere8e811afab72\PhpParser\NodeTraverser();
        $this->addNewServiceToSymfonyPhpConfigRector->setRectorClass($rectorFqnName);
        $nodeTraverser->addVisitor($this->addNewServiceToSymfonyPhpConfigRector);
        $setConfigNodes = $nodeTraverser->traverse($setConfigNodes);
        // 3. print the content back to file
        $changedSetConfigContent = $this->betterStandardPrinter->prettyPrintFile($setConfigNodes);
        $this->smartFileSystem->dumpFile($setFileInfo->getRealPath(), $changedSetConfigContent);
    }
    /**
     * @param Node[] $nodes
     */
    private function decorateNamesToFullyQualified(array $nodes) : void
    {
        // decorate nodes with names first
        $nameResolverNodeTraverser = new \_PhpScopere8e811afab72\PhpParser\NodeTraverser();
        $nameResolverNodeTraverser->addVisitor(new \_PhpScopere8e811afab72\PhpParser\NodeVisitor\NameResolver());
        $nameResolverNodeTraverser->traverse($nodes);
    }
}
