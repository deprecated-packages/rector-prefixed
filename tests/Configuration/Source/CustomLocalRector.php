<?php

declare (strict_types=1);
namespace Rector\Core\Tests\Configuration\Source;

use Rector\Core\Contract\Rector\RectorInterface;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class CustomLocalRector implements \Rector\Core\Contract\Rector\RectorInterface
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        // TODO: Implement getDefinition() method.
    }
}
