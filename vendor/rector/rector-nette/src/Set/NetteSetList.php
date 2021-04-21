<?php

declare(strict_types=1);

namespace Rector\Nette\Set;

use Rector\Set\Contract\SetListInterface;

final class NetteSetList implements SetListInterface
{
    /**
     * @var string
     */
    const NETTE_24 = __DIR__ . '/../../config/sets/nette-24.php';

    /**
     * @var string
     */
    const NETTE_30 = __DIR__ . '/../../config/sets/nette-30.php';

    /**
     * @var string
     */
    const NETTE_31 = __DIR__ . '/../../config/sets/nette-31.php';

    /**
     * @var string
     */
    const NETTE_CODE_QUALITY = __DIR__ . '/../../config/sets/nette-code-quality.php';

    /**
     * @var string
     */
    const NETTE_UTILS_CODE_QUALITY = __DIR__ . '/../../config/sets/nette-utils-code-quality.php';
}
