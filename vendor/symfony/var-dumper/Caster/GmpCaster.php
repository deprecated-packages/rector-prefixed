<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix2020DecSat\Symfony\Component\VarDumper\Caster;

use RectorPrefix2020DecSat\Symfony\Component\VarDumper\Cloner\Stub;
/**
 * Casts GMP objects to array representation.
 *
 * @author Hamza Amrouche <hamza.simperfit@gmail.com>
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @final
 */
class GmpCaster
{
    public static function castGmp(\GMP $gmp, array $a, \RectorPrefix2020DecSat\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested, int $filter) : array
    {
        $a[\RectorPrefix2020DecSat\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . 'value'] = new \RectorPrefix2020DecSat\Symfony\Component\VarDumper\Caster\ConstStub(\gmp_strval($gmp), \gmp_strval($gmp));
        return $a;
    }
}
