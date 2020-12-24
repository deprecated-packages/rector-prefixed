<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Category;

use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\Contract\Category\CategoryInfererInterface;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class CategoryResolver
{
    /**
     * @var string
     */
    private const CATEGORY_UNKNOWN = 'unknown';
    /**
     * @var CategoryInfererInterface[]
     */
    private $categoryInferers = [];
    /**
     * @param CategoryInfererInterface[] $categoryInferers
     */
    public function __construct(array $categoryInferers)
    {
        $this->categoryInferers = $categoryInferers;
    }
    public function resolve(\_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : string
    {
        foreach ($this->categoryInferers as $categoryInferer) {
            $category = $categoryInferer->infer($ruleDefinition);
            if ($category) {
                return $category;
            }
        }
        return self::CATEGORY_UNKNOWN;
    }
}
