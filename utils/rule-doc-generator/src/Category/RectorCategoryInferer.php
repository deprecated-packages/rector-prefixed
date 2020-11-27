<?php

declare (strict_types=1);
namespace Rector\RuleDocGenerator\Category;

use _PhpScopera143bcca66cb\Nette\Utils\Strings;
use Rector\Core\Exception\ShouldNotHappenException;
use Symplify\RuleDocGenerator\Contract\Category\CategoryInfererInterface;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class RectorCategoryInferer implements \Symplify\RuleDocGenerator\Contract\Category\CategoryInfererInterface
{
    /**
     * @see https://regex101.com/r/wyW01F/1
     * @var string
     */
    private const RECTOR_CATEGORY_REGEX = '#Rector\\\\(?<category>\\w+)\\\\#';
    public function infer(\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $ruleDefinition) : ?string
    {
        $matches = \_PhpScopera143bcca66cb\Nette\Utils\Strings::match($ruleDefinition->getRuleClass(), self::RECTOR_CATEGORY_REGEX);
        if (!isset($matches['category'])) {
            $message = \sprintf('Category for "%s" could not be resolved', $ruleDefinition->getRuleClass());
            throw new \Rector\Core\Exception\ShouldNotHappenException($message);
        }
        return $matches['category'];
    }
}
