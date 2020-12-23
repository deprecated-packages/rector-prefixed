<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\Config;

use _PhpScoper0a2ac50786fa\Symfony\Component\Config\FileLocator as BaseFileLocator;
use _PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\KernelInterface;
/**
 * FileLocator uses the KernelInterface to locate resources in bundles.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class FileLocator extends \_PhpScoper0a2ac50786fa\Symfony\Component\Config\FileLocator
{
    private $kernel;
    public function __construct(\_PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        parent::__construct();
    }
    /**
     * {@inheritdoc}
     */
    public function locate(string $file, string $currentPath = null, bool $first = \true)
    {
        if (isset($file[0]) && '@' === $file[0]) {
            $resource = $this->kernel->locateResource($file);
            return $first ? $resource : [$resource];
        }
        return parent::locate($file, $currentPath, $first);
    }
}
