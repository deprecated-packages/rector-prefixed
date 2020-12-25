<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\Blameable;

use _PhpScoper50d83356d739\Gedmo\Mapping\Annotation as Gedmo;
final class BlameableTag
{
    /**
     * @Gedmo\Blameable(on="create")
     */
    protected $gitoliteName;
}
