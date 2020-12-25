<?php

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    Jan Schneider <jan@horde.org>
 * @copyright 2017 Mike van Riel<mike@phpdoc.org>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */
namespace _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\Formatter;

use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tag;
use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\Formatter;
class AlignFormatter implements \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\Formatter
{
    /** @var int The maximum tag name length. */
    protected $maxLen = 0;
    /**
     * Constructor.
     *
     * @param Tag[] $tags All tags that should later be aligned with the formatter.
     */
    public function __construct(array $tags)
    {
        foreach ($tags as $tag) {
            $this->maxLen = \max($this->maxLen, \strlen($tag->getName()));
        }
    }
    /**
     * Formats the given tag to return a simple plain text version.
     *
     * @param Tag $tag
     *
     * @return string
     */
    public function format(\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tag $tag)
    {
        return '@' . $tag->getName() . \str_repeat(' ', $this->maxLen - \strlen($tag->getName()) + 1) . (string) $tag;
    }
}
