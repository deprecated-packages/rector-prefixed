<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Exception;

use Exception;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface;
final class ConflictingPriorityException extends \Exception
{
    public function __construct(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface $firstPriorityAwareTypeInferer, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface $secondPriorityAwareTypeInferer)
    {
        $message = \sprintf('There are 2 type inferers with %d priority:%s- %s%s- %s.%sChange value in "getPriority()" method in one of them to different value', $firstPriorityAwareTypeInferer->getPriority(), \PHP_EOL, \get_class($firstPriorityAwareTypeInferer), \PHP_EOL, \get_class($secondPriorityAwareTypeInferer), \PHP_EOL);
        parent::__construct($message);
    }
}
