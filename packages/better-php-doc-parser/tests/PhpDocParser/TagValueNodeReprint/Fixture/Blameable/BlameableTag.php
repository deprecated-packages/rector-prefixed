<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\Blameable;

use _PhpScoper8b9c402c5f32\Gedmo\Mapping\Annotation as Gedmo;
final class BlameableTag
{
    /**
     * @Gedmo\Blameable(on="create")
     */
    protected $gitoliteName;
}
