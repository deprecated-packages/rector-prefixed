<?php

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright 2010-2015 Mike van Riel<mike@phpdoc.org>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */
namespace _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\Formatter;

use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tag;
use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\Formatter;
class PassthroughFormatter implements \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\Formatter
{
    /**
     * Formats the given tag to return a simple plain text version.
     *
     * @param Tag $tag
     *
     * @return string
     */
    public function format(\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tag $tag)
    {
        return \trim('@' . $tag->getName() . ' ' . (string) $tag);
    }
}
