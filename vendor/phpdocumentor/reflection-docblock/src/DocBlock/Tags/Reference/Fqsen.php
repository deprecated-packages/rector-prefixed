<?php

/**
 * This file is part of phpDocumentor.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 *  @copyright 2010-2017 Mike van Riel<mike@phpdoc.org>
 *  @license   http://www.opensource.org/licenses/mit-license.php MIT
 *  @link      http://phpdoc.org
 */
namespace _PhpScoper26e51eeacccf\phpDocumentor\Reflection\DocBlock\Tags\Reference;

use _PhpScoper26e51eeacccf\phpDocumentor\Reflection\Fqsen as RealFqsen;
/**
 * Fqsen reference used by {@see phpDocumentor\Reflection\DocBlock\Tags\See}
 */
final class Fqsen implements \_PhpScoper26e51eeacccf\phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference
{
    /**
     * @var RealFqsen
     */
    private $fqsen;
    /**
     * Fqsen constructor.
     */
    public function __construct(\_PhpScoper26e51eeacccf\phpDocumentor\Reflection\Fqsen $fqsen)
    {
        $this->fqsen = $fqsen;
    }
    /**
     * @return string string representation of the referenced fqsen
     */
    public function __toString()
    {
        return (string) $this->fqsen;
    }
}
