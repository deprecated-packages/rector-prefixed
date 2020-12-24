<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\ConstantReference;

use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source\ApiFilter;
use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping as ORM;
final class Book
{
    /**
     * @ApiFilter(Book::class)
     * @ORM\Column()
     */
    public $filterable;
}
