<?php

declare (strict_types=1);
namespace Rector\Utils\NodeDocumentationGenerator\Command;

use Rector\Core\Console\Command\AbstractCommand;
use Rector\Utils\NodeDocumentationGenerator\NodeInfosFactory;
use Rector\Utils\NodeDocumentationGenerator\Printer\MarkdownNodeInfosPrinter;
use _PhpScoperabd03f0baf05\Symfony\Component\Console\Input\InputInterface;
use _PhpScoperabd03f0baf05\Symfony\Component\Console\Input\InputOption;
use _PhpScoperabd03f0baf05\Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\PackageBuilder\Console\ShellCode;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;
final class DumpNodesCommand extends \Rector\Core\Console\Command\AbstractCommand
{
    /**
     * @var string
     */
    private const OUTPUT_FILE = 'output-file';
    /**
     * @var MarkdownNodeInfosPrinter
     */
    private $markdownNodeInfosPrinter;
    /**
     * @var NodeInfosFactory
     */
    private $nodeInfosFactory;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    public function __construct(\Rector\Utils\NodeDocumentationGenerator\Printer\MarkdownNodeInfosPrinter $markdownNodeInfosPrinter, \Rector\Utils\NodeDocumentationGenerator\NodeInfosFactory $nodeInfosFactory, \Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle)
    {
        $this->markdownNodeInfosPrinter = $markdownNodeInfosPrinter;
        $this->nodeInfosFactory = $nodeInfosFactory;
        $this->smartFileSystem = $smartFileSystem;
        $this->symfonyStyle = $symfonyStyle;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setDescription('[DOCS] Dump overview of all Nodes');
        $this->addOption(self::OUTPUT_FILE, null, \_PhpScoperabd03f0baf05\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Where to output the file', \getcwd() . '/docs/nodes_overview.md');
    }
    protected function execute(\_PhpScoperabd03f0baf05\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoperabd03f0baf05\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $outputFile = (string) $input->getOption(self::OUTPUT_FILE);
        $nodeInfos = $this->nodeInfosFactory->create();
        $printedContent = $this->markdownNodeInfosPrinter->print($nodeInfos);
        $this->smartFileSystem->dumpFile($outputFile, $printedContent);
        $outputFileFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo($outputFile);
        $message = \sprintf('Documentation for "%d" PhpParser Nodes was generated to "%s"', \count($nodeInfos), $outputFileFileInfo->getRelativeFilePathFromCwd());
        $this->symfonyStyle->success($message);
        return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
