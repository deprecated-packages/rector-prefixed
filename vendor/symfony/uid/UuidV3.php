<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210408\Symfony\Component\Uid;

/**
 * A v3 UUID contains an MD5 hash of another UUID and a name.
 *
 * Use Uuid::v3() to compute one.
 *
 * @experimental in 5.2
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class UuidV3 extends \RectorPrefix20210408\Symfony\Component\Uid\Uuid
{
    protected const TYPE = 3;
}
