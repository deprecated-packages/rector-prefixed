<?php

declare (strict_types=1);
namespace Rector\Composer\Contract\Rector;

use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Contract\Rector\RectorInterface;
use RectorPrefix20210120\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use Symplify\RuleDocGenerator\Contract\ConfigurableRuleInterface;
interface ComposerRectorInterface extends \Rector\Core\Contract\Rector\RectorInterface, \Symplify\RuleDocGenerator\Contract\ConfigurableRuleInterface, \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    public function refactor(\RectorPrefix20210120\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : void;
}
