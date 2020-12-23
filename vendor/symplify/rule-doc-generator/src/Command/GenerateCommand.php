<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\Command;

use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputArgument;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputOption;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\ShellCode;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\DirectoryToMarkdownPrinter;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\Option;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class GenerateCommand extends \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
{
    /**
     * @var DirectoryToMarkdownPrinter
     */
    private $directoryToMarkdownPrinter;
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\DirectoryToMarkdownPrinter $directoryToMarkdownPrinter)
    {
        parent::__construct();
        $this->directoryToMarkdownPrinter = $directoryToMarkdownPrinter;
    }
    protected function configure() : void
    {
        $this->setDescription('Generated Markdown documentation based on documented rules found in directory');
        $this->addArgument(\_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\Option::PATHS, \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputArgument::REQUIRED | \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Path to directory of your project');
        $this->addOption(\_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\Option::OUTPUT_FILE, null, \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to output generated markdown file', \getcwd() . '/docs/rules_overview.md');
        $this->addOption(\_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\Option::CATEGORIZE, null, \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Group in categories');
    }
    protected function execute(\_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $paths = (array) $input->getArgument(\_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\Option::PATHS);
        $shouldCategorize = (bool) $input->getOption(\_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\Option::CATEGORIZE);
        $markdownFileContent = $this->directoryToMarkdownPrinter->print($paths, $shouldCategorize);
        // dump markdown file
        $outputFilePath = (string) $input->getOption(\_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\Option::OUTPUT_FILE);
        $this->smartFileSystem->dumpFile($outputFilePath, $markdownFileContent);
        $outputFileInfo = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo($outputFilePath);
        $message = \sprintf('File "%s" was created', $outputFileInfo->getRelativeFilePathFromCwd());
        $this->symfonyStyle->success($message);
        return \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
