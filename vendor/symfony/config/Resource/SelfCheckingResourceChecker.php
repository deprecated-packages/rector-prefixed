<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopere8e811afab72\Symfony\Component\Config\Resource;

use _PhpScopere8e811afab72\Symfony\Component\Config\ResourceCheckerInterface;
/**
 * Resource checker for instances of SelfCheckingResourceInterface.
 *
 * As these resources perform the actual check themselves, we can provide
 * this class as a standard way of validating them.
 *
 * @author Matthias Pigulla <mp@webfactory.de>
 */
class SelfCheckingResourceChecker implements \_PhpScopere8e811afab72\Symfony\Component\Config\ResourceCheckerInterface
{
    public function supports(\_PhpScopere8e811afab72\Symfony\Component\Config\Resource\ResourceInterface $metadata)
    {
        return $metadata instanceof \_PhpScopere8e811afab72\Symfony\Component\Config\Resource\SelfCheckingResourceInterface;
    }
    public function isFresh(\_PhpScopere8e811afab72\Symfony\Component\Config\Resource\ResourceInterface $resource, int $timestamp)
    {
        /* @var SelfCheckingResourceInterface $resource */
        return $resource->isFresh($timestamp);
    }
}
