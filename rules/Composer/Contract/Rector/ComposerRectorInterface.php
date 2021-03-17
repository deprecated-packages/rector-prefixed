<?php

declare (strict_types=1);
namespace Rector\Composer\Contract\Rector;

use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Contract\Rector\RectorInterface;
use RectorPrefix20210317\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
interface ComposerRectorInterface extends \Rector\Core\Contract\Rector\RectorInterface, \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @param \Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson
     */
    public function refactor($composerJson) : void;
}
