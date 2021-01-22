<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210122\Symfony\Component\Cache\Marshaller;

use RectorPrefix20210122\Symfony\Component\Cache\Exception\CacheException;
/**
 * Compresses values using gzdeflate().
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DeflateMarshaller implements \RectorPrefix20210122\Symfony\Component\Cache\Marshaller\MarshallerInterface
{
    private $marshaller;
    public function __construct(\RectorPrefix20210122\Symfony\Component\Cache\Marshaller\MarshallerInterface $marshaller)
    {
        if (!\function_exists('gzdeflate')) {
            throw new \RectorPrefix20210122\Symfony\Component\Cache\Exception\CacheException('The "zlib" PHP extension is not loaded.');
        }
        $this->marshaller = $marshaller;
    }
    /**
     * {@inheritdoc}
     */
    public function marshall(array $values, ?array &$failed) : array
    {
        return \array_map('gzdeflate', $this->marshaller->marshall($values, $failed));
    }
    /**
     * {@inheritdoc}
     */
    public function unmarshall(string $value)
    {
        if (\false !== ($inflatedValue = @\gzinflate($value))) {
            $value = $inflatedValue;
        }
        return $this->marshaller->unmarshall($value);
    }
}
