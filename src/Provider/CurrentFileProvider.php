<?php

declare (strict_types=1);
namespace Rector\Core\Provider;

use Rector\Core\ValueObject\Application\File;
final class CurrentFileProvider
{
    /**
     * @var File|null
     */
    private $file;
    /**
     * @return void
     */
    public function setFile(\Rector\Core\ValueObject\Application\File $file)
    {
        $this->file = $file;
    }
    public function getFile() : ?\Rector\Core\ValueObject\Application\File
    {
        return $this->file;
    }
}
