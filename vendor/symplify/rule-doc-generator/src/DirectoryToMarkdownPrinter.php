<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator;

use RectorPrefix20210316\Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\Finder\ClassByTypeFinder;
use Symplify\RuleDocGenerator\Printer\RuleDefinitionsPrinter;
use Symplify\RuleDocGenerator\ValueObject\RuleClassWithFilePath;
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
    public function __construct(\Symplify\RuleDocGenerator\Finder\ClassByTypeFinder $classByTypeFinder, \RectorPrefix20210316\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \Symplify\RuleDocGenerator\RuleDefinitionsResolver $ruleDefinitionsResolver, \Symplify\RuleDocGenerator\Printer\RuleDefinitionsPrinter $ruleDefinitionsPrinter)
    {
        $this->classByTypeFinder = $classByTypeFinder;
        $this->symfonyStyle = $symfonyStyle;
        $this->ruleDefinitionsResolver = $ruleDefinitionsResolver;
        $this->ruleDefinitionsPrinter = $ruleDefinitionsPrinter;
    }
    /**
     * @param string[] $directories
     */
    public function print(string $workingDirectory, array $directories, bool $shouldCategorize = \false) : string
    {
        // 1. collect documented rules in provided path
        $documentedRuleClasses = $this->classByTypeFinder->findByType($workingDirectory, $directories, \Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface::class);
        $message = \sprintf('Found %d documented rule classes', \count($documentedRuleClasses));
        $this->symfonyStyle->note($message);
        $classes = \array_map(function (\Symplify\RuleDocGenerator\ValueObject\RuleClassWithFilePath $rule) : string {
            return $rule->getClass();
        }, $documentedRuleClasses);
        $this->symfonyStyle->listing($classes);
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
