<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Caster;

use _PhpScoperbf340cb0be9d\Ramsey\Uuid\UuidInterface;
use _PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Cloner\Stub;
/**
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
final class UuidCaster
{
    public static function castRamseyUuid(\_PhpScoperbf340cb0be9d\Ramsey\Uuid\UuidInterface $c, array $a, \_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested) : array
    {
        $a += [\_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . 'uuid' => (string) $c];
        return $a;
    }
}
