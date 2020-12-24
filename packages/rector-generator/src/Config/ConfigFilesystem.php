<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RectorGenerator\Config;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitor\NameResolver;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Parser\Parser;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector;
use _PhpScoperb75b35f52b74\Rector\RectorGenerator\TemplateFactory;
use _PhpScoperb75b35f52b74\Rector\RectorGenerator\ValueObject\RectorRecipe;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
final class ConfigFilesystem
{
    /**
     * @var string
     */
    public const RECTOR_FQN_NAME_PATTERN = '_PhpScoperb75b35f52b74\\Rector\\__Package__\\Rector\\__Category__\\__Name__';
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector $addNewServiceToSymfonyPhpConfigRector, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Parser\Parser $parser, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScoperb75b35f52b74\Rector\RectorGenerator\TemplateFactory $templateFactory)
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
    public function appendRectorServiceToSet(\_PhpScoperb75b35f52b74\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe, array $templateVariables) : void
    {
        if ($rectorRecipe->getSet() === null) {
            return;
        }
        $setFilePath = $rectorRecipe->getSet();
        $setFileInfo = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo($setFilePath);
        $setFileContents = $setFileInfo->getContents();
        // already added?
        $rectorFqnName = $this->templateFactory->create(self::RECTOR_FQN_NAME_PATTERN, $templateVariables);
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($setFileContents, $rectorFqnName)) {
            return;
        }
        // 1. parse the file
        $setConfigNodes = $this->parser->parseFileInfo($setFileInfo);
        // 2. add the set() call
        $this->decorateNamesToFullyQualified($setConfigNodes);
        $nodeTraverser = new \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser();
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
        $nameResolverNodeTraverser = new \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser();
        $nameResolverNodeTraverser->addVisitor(new \_PhpScoperb75b35f52b74\PhpParser\NodeVisitor\NameResolver());
        $nameResolverNodeTraverser->traverse($nodes);
    }
}
