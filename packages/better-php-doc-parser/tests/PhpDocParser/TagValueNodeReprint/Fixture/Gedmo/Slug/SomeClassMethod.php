<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\Gedmo\Slug;

use _PhpScoperbf340cb0be9d\Gedmo\Mapping\Annotation as Gedmo;
final class SomeClassMethod
{
    /**
     * @Gedmo\Slug(fields={"lastName", "firstName"}, prefix="papo-")
     */
    protected $gitoliteName;
}
