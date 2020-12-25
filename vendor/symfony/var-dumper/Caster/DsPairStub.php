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

use _PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Cloner\Stub;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DsPairStub extends \_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Cloner\Stub
{
    public function __construct($key, $value)
    {
        $this->value = [\_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . 'key' => $key, \_PhpScoperbf340cb0be9d\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . 'value' => $value];
    }
}
