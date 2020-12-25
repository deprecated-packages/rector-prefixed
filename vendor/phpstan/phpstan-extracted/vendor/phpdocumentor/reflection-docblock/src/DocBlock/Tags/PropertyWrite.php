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
namespace _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags;

use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Description;
use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Type;
use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\TypeResolver;
use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context as TypeContext;
use _HumbugBox221ad6f1b81f\Webmozart\Assert\Assert;
/**
 * Reflection class for a {@}property-write tag in a Docblock.
 */
class PropertyWrite extends \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\TagWithType implements \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod
{
    /** @var string */
    protected $variableName = '';
    /**
     * @param string $variableName
     * @param Type $type
     * @param Description $description
     */
    public function __construct($variableName, \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Type $type = null, \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Description $description = null)
    {
        \_HumbugBox221ad6f1b81f\Webmozart\Assert\Assert::string($variableName);
        $this->name = 'property-write';
        $this->variableName = $variableName;
        $this->type = $type;
        $this->description = $description;
    }
    /**
     * {@inheritdoc}
     */
    public static function create($body, \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\TypeResolver $typeResolver = null, \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\DescriptionFactory $descriptionFactory = null, \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context $context = null)
    {
        \_HumbugBox221ad6f1b81f\Webmozart\Assert\Assert::stringNotEmpty($body);
        \_HumbugBox221ad6f1b81f\Webmozart\Assert\Assert::allNotNull([$typeResolver, $descriptionFactory]);
        list($firstPart, $body) = self::extractTypeFromBody($body);
        $type = null;
        $parts = \preg_split('/(\\s+)/Su', $body, 2, \PREG_SPLIT_DELIM_CAPTURE);
        $variableName = '';
        // if the first item that is encountered is not a variable; it is a type
        if ($firstPart && \strlen($firstPart) > 0 && $firstPart[0] !== '$') {
            $type = $typeResolver->resolve($firstPart, $context);
        } else {
            // first part is not a type; we should prepend it to the parts array for further processing
            \array_unshift($parts, $firstPart);
        }
        // if the next item starts with a $ or ...$ it must be the variable name
        if (isset($parts[0]) && \strlen($parts[0]) > 0 && $parts[0][0] === '$') {
            $variableName = \array_shift($parts);
            \array_shift($parts);
            if (\substr($variableName, 0, 1) === '$') {
                $variableName = \substr($variableName, 1);
            }
        }
        $description = $descriptionFactory->create(\implode('', $parts), $context);
        return new static($variableName, $type, $description);
    }
    /**
     * Returns the variable's name.
     *
     * @return string
     */
    public function getVariableName()
    {
        return $this->variableName;
    }
    /**
     * Returns a string representation for this tag.
     *
     * @return string
     */
    public function __toString()
    {
        return ($this->type ? $this->type . ' ' : '') . '$' . $this->variableName . ($this->description ? ' ' . $this->description : '');
    }
}
