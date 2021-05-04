<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210504\Symfony\Component\VarDumper\Caster;

use RectorPrefix20210504\Imagine\Image\ImageInterface;
use RectorPrefix20210504\Symfony\Component\VarDumper\Cloner\Stub;
/**
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
final class ImagineCaster
{
    public static function castImage(\RectorPrefix20210504\Imagine\Image\ImageInterface $c, array $a, \RectorPrefix20210504\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested) : array
    {
        $imgData = $c->get('png');
        if (\strlen($imgData) > 1 * 1000 * 1000) {
            $a += [\RectorPrefix20210504\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . 'image' => new \RectorPrefix20210504\Symfony\Component\VarDumper\Caster\ConstStub($c->getSize())];
        } else {
            $a += [\RectorPrefix20210504\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . 'image' => new \RectorPrefix20210504\Symfony\Component\VarDumper\Caster\ImgStub($imgData, 'image/png', $c->getSize())];
        }
        return $a;
    }
}
