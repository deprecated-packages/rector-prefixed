<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\Tests\DirectoryToMarkdownPrinter\Source;

use Symplify\RuleDocGenerator\Contract\Category\CategoryInfererInterface;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class SimpleCategoryInferer implements \Symplify\RuleDocGenerator\Contract\Category\CategoryInfererInterface
{
    public function infer(\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : ?string
    {
        return 'Big Category';
    }
}
