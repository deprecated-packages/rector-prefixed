<?php

declare (strict_types=1);
/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */
namespace _PhpScoper88fe6e0ad041\phpDocumentor\Reflection;

interface PseudoType extends \_PhpScoper88fe6e0ad041\phpDocumentor\Reflection\Type
{
    public function underlyingType() : \_PhpScoper88fe6e0ad041\phpDocumentor\Reflection\Type;
}