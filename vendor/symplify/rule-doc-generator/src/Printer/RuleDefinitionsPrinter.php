<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Category\CategoryResolver;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\CodeSamplePrinter;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Text\KeywordHighlighter;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\Lines;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class RuleDefinitionsPrinter
{
    /**
     * @var CodeSamplePrinter
     */
    private $codeSamplePrinter;
    /**
     * @var KeywordHighlighter
     */
    private $keywordHighlighter;
    /**
     * @var CategoryResolver
     */
    private $categoryResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Printer\CodeSamplePrinter\CodeSamplePrinter $codeSamplePrinter, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Text\KeywordHighlighter $keywordHighlighter, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Category\CategoryResolver $categoryResolver)
    {
        $this->codeSamplePrinter = $codeSamplePrinter;
        $this->keywordHighlighter = $keywordHighlighter;
        $this->categoryResolver = $categoryResolver;
    }
    /**
     * @param RuleDefinition[] $ruleDefinitions
     * @return string[]
     */
    public function print(array $ruleDefinitions, bool $shouldCategorize) : array
    {
        $ruleCount = \count($ruleDefinitions);
        $lines = [];
        $lines[] = \sprintf('# %d Rules Overview', $ruleCount);
        if ($shouldCategorize) {
            $ruleDefinitionsByCategory = $this->groupDefinitionsByCategory($ruleDefinitions);
            $categoryMenuLines = $this->createCategoryMenu($ruleDefinitionsByCategory);
            $lines = \array_merge($lines, $categoryMenuLines);
            foreach ($ruleDefinitionsByCategory as $category => $ruleDefinitions) {
                $lines[] = '## ' . $category;
                $lines = $this->printRuleDefinitions($ruleDefinitions, $lines, $shouldCategorize);
            }
        } else {
            $lines = $this->printRuleDefinitions($ruleDefinitions, $lines);
        }
        return $lines;
    }
    /**
     * @param RuleDefinition[] $ruleDefinitions
     * @return array<string, RuleDefinition[]>
     */
    private function groupDefinitionsByCategory(array $ruleDefinitions) : array
    {
        $ruleDefinitionsByCategory = [];
        foreach ($ruleDefinitions as $ruleDefinition) {
            $category = $this->categoryResolver->resolve($ruleDefinition);
            $ruleDefinitionsByCategory[$category][] = $ruleDefinition;
        }
        \ksort($ruleDefinitionsByCategory);
        return $ruleDefinitionsByCategory;
    }
    /**
     * @param RuleDefinition[] $ruleDefinitions
     * @param string[] $lines
     * @return string[]
     */
    private function printRuleDefinitions(array $ruleDefinitions, array $lines, bool $shouldCategorize = \false) : array
    {
        foreach ($ruleDefinitions as $ruleDefinition) {
            if ($shouldCategorize) {
                $lines[] = '### ' . $ruleDefinition->getRuleShortClass();
            } else {
                $lines[] = '## ' . $ruleDefinition->getRuleShortClass();
            }
            $lines[] = $this->keywordHighlighter->highlight($ruleDefinition->getDescription());
            if ($ruleDefinition->isConfigurable()) {
                $lines[] = \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\Lines::CONFIGURE_IT;
            }
            $lines[] = '- class: `' . $ruleDefinition->getRuleClass() . '`';
            $codeSampleLines = $this->codeSamplePrinter->print($ruleDefinition);
            $lines = \array_merge($lines, $codeSampleLines);
        }
        return $lines;
    }
    /**
     * @param array<string, RuleDefinition[]> $ruleDefinitionsByCategory
     * @return string[]
     */
    private function createCategoryMenu(array $ruleDefinitionsByCategory) : array
    {
        $lines = [];
        $lines[] = '<br>';
        $lines[] = '## Categories';
        foreach ($ruleDefinitionsByCategory as $category => $ruleDefinitions) {
            $lines[] = \sprintf('- [%s](#%s) (%d)', $category, \_PhpScoperb75b35f52b74\Nette\Utils\Strings::webalize($category), \count($ruleDefinitions));
        }
        $lines[] = '<br>';
        return $lines;
    }
}
