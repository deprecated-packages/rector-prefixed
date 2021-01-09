<?php

declare (strict_types=1);
namespace Rector\Core\Exclusion\Source;

use Rector\Core\Contract\Rector\RectorInterface;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class SomeRector implements \Rector\Core\Contract\Rector\RectorInterface
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('...', []);
    }
}
