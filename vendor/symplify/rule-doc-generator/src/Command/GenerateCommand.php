<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\Command;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputArgument;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputOption;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Console\ShellCode;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\DirectoryToMarkdownPrinter;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\Option;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class GenerateCommand extends \_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
{
    /**
     * @var DirectoryToMarkdownPrinter
     */
    private $directoryToMarkdownPrinter;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\DirectoryToMarkdownPrinter $directoryToMarkdownPrinter)
    {
        parent::__construct();
        $this->directoryToMarkdownPrinter = $directoryToMarkdownPrinter;
    }
    protected function configure() : void
    {
        $this->setDescription('Generated Markdown documentation based on documented rules found in directory');
        $this->addArgument(\_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\Option::PATHS, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputArgument::REQUIRED | \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Path to directory of your project');
        $this->addOption(\_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\Option::OUTPUT_FILE, null, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to output generated markdown file', \getcwd() . '/docs/rules_overview.md');
        $this->addOption(\_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\Option::CATEGORIZE, null, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Group in categories');
    }
    protected function execute(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $paths = (array) $input->getArgument(\_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\Option::PATHS);
        $shouldCategorize = (bool) $input->getOption(\_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\Option::CATEGORIZE);
        $markdownFileContent = $this->directoryToMarkdownPrinter->print($paths, $shouldCategorize);
        // dump markdown file
        $outputFilePath = (string) $input->getOption(\_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\Option::OUTPUT_FILE);
        $this->smartFileSystem->dumpFile($outputFilePath, $markdownFileContent);
        $outputFileInfo = new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo($outputFilePath);
        $message = \sprintf('File "%s" was created', $outputFileInfo->getRelativeFilePathFromCwd());
        $this->symfonyStyle->success($message);
        return \_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
