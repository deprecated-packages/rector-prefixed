<?php

declare(strict_types=1);

namespace Rector\Symfony\Set;

use Rector\Set\Contract\SetListInterface;

final class SwiftmailerSetList implements SetListInterface
{
    /**
     * @var string
     */
    const SWIFTMAILER_60 = __DIR__ . '/../../config/sets/swiftmailer/swiftmailer60.php';
}
