<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\ConstantReference;

use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source\ApiFilter;
use _PhpScopere8e811afab72\Doctrine\ORM\Mapping as ORM;
final class Book
{
    /**
     * @ApiFilter(Book::class)
     * @ORM\Column()
     */
    public $filterable;
}
