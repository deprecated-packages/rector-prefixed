<?php

declare (strict_types=1);
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
namespace _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags;

use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock;
use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Description;
/**
 * Parses a tag definition for a DocBlock.
 */
abstract class BaseTag implements \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tag
{
    /** @var string Name of the tag */
    protected $name = '';
    /** @var Description|null Description of the tag. */
    protected $description;
    /**
     * Gets the name of this tag.
     *
     * @return string The name of this tag.
     */
    public function getName()
    {
        return $this->name;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function render(\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\Formatter $formatter = null)
    {
        if ($formatter === null) {
            $formatter = new \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\Formatter\PassthroughFormatter();
        }
        return $formatter->format($this);
    }
}
