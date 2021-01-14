<?php

declare (strict_types=1);
namespace Rector\Composer\Contract\ComposerModifier;

use RectorPrefix20210114\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
interface ComposerModifierInterface
{
    public function modify(\RectorPrefix20210114\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : \RectorPrefix20210114\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
}
