<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Command;

use _PhpScopere8e811afab72\Symfony\Component\Console\Input\InputArgument;
use _PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface;
use _PhpScopere8e811afab72\Symfony\Component\Console\Input\InputOption;
use _PhpScopere8e811afab72\Symfony\Component\Console\Output\OutputInterface;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Console\ShellCode;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\DirectoryToMarkdownPrinter;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\Option;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class GenerateCommand extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
{
    /**
     * @var DirectoryToMarkdownPrinter
     */
    private $directoryToMarkdownPrinter;
    public function __construct(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\DirectoryToMarkdownPrinter $directoryToMarkdownPrinter)
    {
        parent::__construct();
        $this->directoryToMarkdownPrinter = $directoryToMarkdownPrinter;
    }
    protected function configure() : void
    {
        $this->setDescription('Generated Markdown documentation based on documented rules found in directory');
        $this->addArgument(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\Option::PATHS, \_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputArgument::REQUIRED | \_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Path to directory of your project');
        $this->addOption(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\Option::OUTPUT_FILE, null, \_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to output generated markdown file', \getcwd() . '/docs/rules_overview.md');
        $this->addOption(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\Option::CATEGORIZE, null, \_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Group in categories');
    }
    protected function execute(\_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface $input, \_PhpScopere8e811afab72\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $paths = (array) $input->getArgument(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\Option::PATHS);
        $shouldCategorize = (bool) $input->getOption(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\Option::CATEGORIZE);
        $markdownFileContent = $this->directoryToMarkdownPrinter->print($paths, $shouldCategorize);
        // dump markdown file
        $outputFilePath = (string) $input->getOption(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\Option::OUTPUT_FILE);
        $this->smartFileSystem->dumpFile($outputFilePath, $markdownFileContent);
        $outputFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($outputFilePath);
        $message = \sprintf('File "%s" was created', $outputFileInfo->getRelativeFilePathFromCwd());
        $this->symfonyStyle->success($message);
        return \_PhpScopere8e811afab72\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
