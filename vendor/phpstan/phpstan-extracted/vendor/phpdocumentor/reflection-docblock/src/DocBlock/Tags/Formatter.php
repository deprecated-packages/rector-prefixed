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
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tag;
interface Formatter
{
    /**
     * Formats a tag into a string representation according to a specific format, such as Markdown.
     *
     * @param Tag $tag
     *
     * @return string
     */
    public function format(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tag $tag);
}
