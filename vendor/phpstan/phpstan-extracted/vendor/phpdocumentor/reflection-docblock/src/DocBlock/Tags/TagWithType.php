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
namespace _HumbugBox221ad6f1b81f__UniqueRector\phpDocumentor\Reflection\DocBlock\Tags;

use _HumbugBox221ad6f1b81f__UniqueRector\phpDocumentor\Reflection\Type;
abstract class TagWithType extends \_HumbugBox221ad6f1b81f__UniqueRector\phpDocumentor\Reflection\DocBlock\Tags\BaseTag
{
    /** @var Type */
    protected $type;
    /**
     * Returns the type section of the variable.
     *
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }
    protected static function extractTypeFromBody(string $body) : array
    {
        $type = '';
        $nestingLevel = 0;
        for ($i = 0; $i < \strlen($body); $i++) {
            $character = $body[$i];
            if (\trim($character) === '' && $nestingLevel === 0) {
                break;
            }
            $type .= $character;
            if (\in_array($character, ['<', '(', '[', '{'])) {
                $nestingLevel++;
            }
            if (\in_array($character, ['>', ')', ']', '}'])) {
                $nestingLevel--;
            }
        }
        $description = \trim(\substr($body, \strlen($type)));
        return [$type, $description];
    }
}
