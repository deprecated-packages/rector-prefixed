<?php

declare (strict_types=1);
namespace Rector\Core\Application\FileDecorator;

use Rector\ChangesReporting\ValueObjectFactory\FileDiffFactory;
use Rector\Core\Contract\Application\FileDecoratorInterface;
use Rector\Core\ValueObject\Application\File;
final class FileDiffFileDecorator implements \Rector\Core\Contract\Application\FileDecoratorInterface
{
    /**
     * @var FileDiffFactory
     */
    private $fileDiffFactory;
    public function __construct(\Rector\ChangesReporting\ValueObjectFactory\FileDiffFactory $fileDiffFactory)
    {
        $this->fileDiffFactory = $fileDiffFactory;
    }
    /**
     * @param File[] $files
     * @return void
     */
    public function decorate($files)
    {
        foreach ($files as $file) {
            if (!$file->hasChanged()) {
                continue;
            }
            $fileDiff = $this->fileDiffFactory->createFileDiff($file, $file->getOriginalFileContent(), $file->getFileContent());
            $file->setFileDiff($fileDiff);
        }
    }
}
