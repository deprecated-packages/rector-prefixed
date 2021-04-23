<?php

declare (strict_types=1);
namespace Rector\Core\Contract\Application;

use Rector\Core\ValueObject\Application\File;
interface FileDecoratorInterface
{
    /**
     * @param File[] $files
     * @return void
     */
    public function decorate($files);
}
