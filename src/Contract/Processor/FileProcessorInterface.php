<?php

declare (strict_types=1);
namespace Rector\Core\Contract\Processor;

use Rector\Core\ValueObject\Application\File;
interface FileProcessorInterface
{
    /**
     * @param \Rector\Core\ValueObject\Application\File $file
     */
    public function supports($file) : bool;
    /**
     * @param File[] $files
     * @return void
     */
    public function process($files);
    /**
     * @return string[]
     */
    public function getSupportedFileExtensions() : array;
}
