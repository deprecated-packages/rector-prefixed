<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210115\Symfony\Component\Cache\Adapter;

use RectorPrefix20210115\Symfony\Component\Cache\Marshaller\DefaultMarshaller;
use RectorPrefix20210115\Symfony\Component\Cache\Marshaller\MarshallerInterface;
use RectorPrefix20210115\Symfony\Component\Cache\PruneableInterface;
use RectorPrefix20210115\Symfony\Component\Cache\Traits\FilesystemTrait;
class FilesystemAdapter extends \RectorPrefix20210115\Symfony\Component\Cache\Adapter\AbstractAdapter implements \RectorPrefix20210115\Symfony\Component\Cache\PruneableInterface
{
    use FilesystemTrait;
    public function __construct(string $namespace = '', int $defaultLifetime = 0, string $directory = null, \RectorPrefix20210115\Symfony\Component\Cache\Marshaller\MarshallerInterface $marshaller = null)
    {
        $this->marshaller = $marshaller ?? new \RectorPrefix20210115\Symfony\Component\Cache\Marshaller\DefaultMarshaller();
        parent::__construct('', $defaultLifetime);
        $this->init($namespace, $directory);
    }
}
