<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperfce0de0de1ce\Symfony\Component\Cache\Adapter;

use _PhpScoperfce0de0de1ce\Symfony\Component\Cache\Marshaller\DefaultMarshaller;
use _PhpScoperfce0de0de1ce\Symfony\Component\Cache\Marshaller\MarshallerInterface;
use _PhpScoperfce0de0de1ce\Symfony\Component\Cache\PruneableInterface;
use _PhpScoperfce0de0de1ce\Symfony\Component\Cache\Traits\FilesystemTrait;
class FilesystemAdapter extends \_PhpScoperfce0de0de1ce\Symfony\Component\Cache\Adapter\AbstractAdapter implements \_PhpScoperfce0de0de1ce\Symfony\Component\Cache\PruneableInterface
{
    use FilesystemTrait;
    public function __construct(string $namespace = '', int $defaultLifetime = 0, string $directory = null, \_PhpScoperfce0de0de1ce\Symfony\Component\Cache\Marshaller\MarshallerInterface $marshaller = null)
    {
        $this->marshaller = $marshaller ?? new \_PhpScoperfce0de0de1ce\Symfony\Component\Cache\Marshaller\DefaultMarshaller();
        parent::__construct('', $defaultLifetime);
        $this->init($namespace, $directory);
    }
}
