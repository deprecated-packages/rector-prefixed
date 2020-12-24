<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Command;

use _PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputArgument;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputOption;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\ShellCode;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\DirectoryToMarkdownPrinter;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\Option;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class GenerateCommand extends \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
{
    /**
     * @var DirectoryToMarkdownPrinter
     */
    private $directoryToMarkdownPrinter;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\DirectoryToMarkdownPrinter $directoryToMarkdownPrinter)
    {
        parent::__construct();
        $this->directoryToMarkdownPrinter = $directoryToMarkdownPrinter;
    }
    protected function configure() : void
    {
        $this->setDescription('Generated Markdown documentation based on documented rules found in directory');
        $this->addArgument(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\Option::PATHS, \_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputArgument::REQUIRED | \_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Path to directory of your project');
        $this->addOption(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\Option::OUTPUT_FILE, null, \_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to output generated markdown file', \getcwd() . '/docs/rules_overview.md');
        $this->addOption(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\Option::CATEGORIZE, null, \_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Group in categories');
    }
    protected function execute(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoperb75b35f52b74\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $paths = (array) $input->getArgument(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\Option::PATHS);
        $shouldCategorize = (bool) $input->getOption(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\Option::CATEGORIZE);
        $markdownFileContent = $this->directoryToMarkdownPrinter->print($paths, $shouldCategorize);
        // dump markdown file
        $outputFilePath = (string) $input->getOption(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\Option::OUTPUT_FILE);
        $this->smartFileSystem->dumpFile($outputFilePath, $markdownFileContent);
        $outputFileInfo = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo($outputFilePath);
        $message = \sprintf('File "%s" was created', $outputFileInfo->getRelativeFilePathFromCwd());
        $this->symfonyStyle->success($message);
        return \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
