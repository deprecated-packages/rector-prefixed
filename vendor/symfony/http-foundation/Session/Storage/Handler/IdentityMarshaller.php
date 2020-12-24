<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopere8e811afab72\Symfony\Component\HttpFoundation\Session\Storage\Handler;

use _PhpScopere8e811afab72\Symfony\Component\Cache\Marshaller\MarshallerInterface;
/**
 * @author Ahmed TAILOULOUTE <ahmed.tailouloute@gmail.com>
 */
class IdentityMarshaller implements \_PhpScopere8e811afab72\Symfony\Component\Cache\Marshaller\MarshallerInterface
{
    /**
     * {@inheritdoc}
     */
    public function marshall(array $values, ?array &$failed) : array
    {
        foreach ($values as $key => $value) {
            if (!\is_string($value)) {
                throw new \LogicException(\sprintf('%s accepts only string as data.', __METHOD__));
            }
        }
        return $values;
    }
    /**
     * {@inheritdoc}
     */
    public function unmarshall(string $value) : string
    {
        return $value;
    }
}
