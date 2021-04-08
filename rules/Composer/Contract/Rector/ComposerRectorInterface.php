<?php

declare (strict_types=1);
namespace Rector\Composer\Contract\Rector;

use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Contract\Rector\RectorInterface;
use RectorPrefix20210408\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
interface ComposerRectorInterface extends \Rector\Core\Contract\Rector\RectorInterface, \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    public function refactor(\RectorPrefix20210408\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : void;
}
