<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\RectorGenerator\Config;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\NodeTraverser;
use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NameResolver;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Parser\Parser;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a2ac50786fa\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector;
use _PhpScoper0a2ac50786fa\Rector\RectorGenerator\TemplateFactory;
use _PhpScoper0a2ac50786fa\Rector\RectorGenerator\ValueObject\RectorRecipe;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem;
final class ConfigFilesystem
{
    /**
     * @var string
     */
    public const RECTOR_FQN_NAME_PATTERN = '_PhpScoper0a2ac50786fa\\Rector\\__Package__\\Rector\\__Category__\\__Name__';
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\RectorGenerator\Rector\Closure\AddNewServiceToSymfonyPhpConfigRector $addNewServiceToSymfonyPhpConfigRector, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Parser\Parser $parser, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScoper0a2ac50786fa\Rector\RectorGenerator\TemplateFactory $templateFactory)
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
    public function appendRectorServiceToSet(\_PhpScoper0a2ac50786fa\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe, array $templateVariables) : void
    {
        if ($rectorRecipe->getSet() === null) {
            return;
        }
        $setFilePath = $rectorRecipe->getSet();
        $setFileInfo = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo($setFilePath);
        $setFileContents = $setFileInfo->getContents();
        // already added?
        $rectorFqnName = $this->templateFactory->create(self::RECTOR_FQN_NAME_PATTERN, $templateVariables);
        if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::contains($setFileContents, $rectorFqnName)) {
            return;
        }
        // 1. parse the file
        $setConfigNodes = $this->parser->parseFileInfo($setFileInfo);
        // 2. add the set() call
        $this->decorateNamesToFullyQualified($setConfigNodes);
        $nodeTraverser = new \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser();
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
        $nameResolverNodeTraverser = new \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser();
        $nameResolverNodeTraverser->addVisitor(new \_PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NameResolver());
        $nameResolverNodeTraverser->traverse($nodes);
    }
}
