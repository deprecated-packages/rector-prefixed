<?php

declare (strict_types=1);
/**
 * phpDocumentor
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection;

/**
 * Interface for Api Elements
 */
interface Element
{
    /**
     * Returns the Fqsen of the element.
     */
    public function getFqsen() : \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Fqsen;
    /**
     * Returns the name of the element.
     */
    public function getName() : string;
}
