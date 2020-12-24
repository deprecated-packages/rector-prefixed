<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\DependencyInjection;

use _PhpScoper0a6b37af0871\PHPStan\File\FileHelper;
class NeonLoader extends \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Config\Loader
{
    /** @var FileHelper */
    private $fileHelper;
    /** @var string|null */
    private $generateBaselineFile;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\File\FileHelper $fileHelper, ?string $generateBaselineFile)
    {
        $this->fileHelper = $fileHelper;
        $this->generateBaselineFile = $generateBaselineFile;
    }
    /**
     * @param string $file
     * @param bool|null $merge
     * @return mixed[]
     */
    public function load(string $file, ?bool $merge = \true) : array
    {
        if ($this->generateBaselineFile === null) {
            return parent::load($file, $merge);
        }
        $normalizedFile = $this->fileHelper->normalizePath($file);
        if ($this->generateBaselineFile === $normalizedFile) {
            return [];
        }
        return parent::load($file, $merge);
    }
}
