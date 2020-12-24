<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\RuleDocGenerator;

use _PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Finder\ClassByTypeFinder;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\RuleDefinitionsPrinter;
/**
 * @see \Symplify\RuleDocGenerator\Tests\DirectoryToMarkdownPrinter\DirectoryToMarkdownPrinterTest
 */
final class DirectoryToMarkdownPrinter
{
    /**
     * @var ClassByTypeFinder
     */
    private $classByTypeFinder;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var RuleDefinitionsResolver
     */
    private $ruleDefinitionsResolver;
    /**
     * @var RuleDefinitionsPrinter
     */
    private $ruleDefinitionsPrinter;
    public function __construct(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Finder\ClassByTypeFinder $classByTypeFinder, \_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\RuleDefinitionsResolver $ruleDefinitionsResolver, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Printer\RuleDefinitionsPrinter $ruleDefinitionsPrinter)
    {
        $this->classByTypeFinder = $classByTypeFinder;
        $this->symfonyStyle = $symfonyStyle;
        $this->ruleDefinitionsResolver = $ruleDefinitionsResolver;
        $this->ruleDefinitionsPrinter = $ruleDefinitionsPrinter;
    }
    /**
     * @param string[] $directories
     */
    public function print(array $directories, bool $shouldCategorize = \false) : string
    {
        // 1. collect documented rules in provided path
        $documentedRuleClasses = $this->classByTypeFinder->findByType($directories, \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface::class);
        $message = \sprintf('Found %d documented rule classes', \count($documentedRuleClasses));
        $this->symfonyStyle->note($message);
        $this->symfonyStyle->listing($documentedRuleClasses);
        // 2. create rule definition collection
        $ruleDefinitions = $this->ruleDefinitionsResolver->resolveFromClassNames($documentedRuleClasses);
        // 3. print rule definitions to markdown lines
        $markdownLines = $this->ruleDefinitionsPrinter->print($ruleDefinitions, $shouldCategorize);
        $fileContent = '';
        foreach ($markdownLines as $markdownLine) {
            $fileContent .= \trim($markdownLine) . \PHP_EOL . \PHP_EOL;
        }
        return \rtrim($fileContent) . \PHP_EOL;
    }
}
