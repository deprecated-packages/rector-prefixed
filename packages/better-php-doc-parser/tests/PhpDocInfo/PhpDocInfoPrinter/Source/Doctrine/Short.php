<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\Doctrine;

use _PhpScopere8e811afab72\Doctrine\ORM\Mapping as ORM;
use _PhpScopere8e811afab72\Doctrine\ORM\Mapping\UniqueConstraint;
/**
 * @ORM\Table(
 *   uniqueConstraints={
 *      @UniqueConstraint(name="content_status_unique", columns={"content_id", "site_id", "lang"})
 *     }
 * )
 */
final class Short
{
}
