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
namespace _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection;

interface PseudoType extends \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Type
{
    public function underlyingType() : \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Type;
}
