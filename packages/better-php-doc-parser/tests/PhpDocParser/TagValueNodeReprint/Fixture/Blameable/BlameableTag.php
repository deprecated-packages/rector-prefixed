<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\Blameable;

use RectorPrefix20210121\Gedmo\Mapping\Annotation as Gedmo;
final class BlameableTag
{
    /**
     * @Gedmo\Blameable(on="create")
     */
    protected $gitoliteName;
}
