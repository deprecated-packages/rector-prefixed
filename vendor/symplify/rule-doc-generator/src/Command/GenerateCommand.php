<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\Command;

use _PhpScoper267b3276efc2\Symfony\Component\Console\Input\InputArgument;
use _PhpScoper267b3276efc2\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper267b3276efc2\Symfony\Component\Console\Input\InputOption;
use _PhpScoper267b3276efc2\Symfony\Component\Console\Output\OutputInterface;
use Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use Symplify\PackageBuilder\Console\ShellCode;
use Symplify\RuleDocGenerator\DirectoryToMarkdownPrinter;
use Symplify\RuleDocGenerator\ValueObject\Option;
use Symplify\SmartFileSystem\SmartFileInfo;
final class GenerateCommand extends \Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
{
    /**
     * @var DirectoryToMarkdownPrinter
     */
    private $directoryToMarkdownPrinter;
    public function __construct(\Symplify\RuleDocGenerator\DirectoryToMarkdownPrinter $directoryToMarkdownPrinter)
    {
        parent::__construct();
        $this->directoryToMarkdownPrinter = $directoryToMarkdownPrinter;
    }
    protected function configure() : void
    {
        $this->setDescription('Generated Markdown documentation based on documented rules found in directory');
        $this->addArgument(\Symplify\RuleDocGenerator\ValueObject\Option::PATHS, \_PhpScoper267b3276efc2\Symfony\Component\Console\Input\InputArgument::REQUIRED | \_PhpScoper267b3276efc2\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Path to directory of your project');
        $this->addOption(\Symplify\RuleDocGenerator\ValueObject\Option::OUTPUT_FILE, null, \_PhpScoper267b3276efc2\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to output generated markdown file', \getcwd() . '/docs/rules_overview.md');
        $this->addOption(\Symplify\RuleDocGenerator\ValueObject\Option::CATEGORIZE, null, \_PhpScoper267b3276efc2\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Group in categories');
    }
    protected function execute(\_PhpScoper267b3276efc2\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper267b3276efc2\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $paths = (array) $input->getArgument(\Symplify\RuleDocGenerator\ValueObject\Option::PATHS);
        $shouldCategorize = (bool) $input->getOption(\Symplify\RuleDocGenerator\ValueObject\Option::CATEGORIZE);
        $markdownFileContent = $this->directoryToMarkdownPrinter->print($paths, $shouldCategorize);
        // dump markdown file
        $outputFilePath = (string) $input->getOption(\Symplify\RuleDocGenerator\ValueObject\Option::OUTPUT_FILE);
        $this->smartFileSystem->dumpFile($outputFilePath, $markdownFileContent);
        $outputFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo($outputFilePath);
        $message = \sprintf('File "%s" was created', $outputFileInfo->getRelativeFilePathFromCwd());
        $this->symfonyStyle->success($message);
        return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
