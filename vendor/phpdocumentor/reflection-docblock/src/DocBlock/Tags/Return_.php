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
namespace _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Tags;

use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Description;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Type;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\TypeResolver;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Types\Context as TypeContext;
use _PhpScoperbd5d0c5f7638\Webmozart\Assert\Assert;
/**
 * Reflection class for a {@}return tag in a Docblock.
 */
final class Return_ extends \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Tags\TagWithType implements \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod
{
    public function __construct(\_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Type $type, \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Description $description = null)
    {
        $this->name = 'return';
        $this->type = $type;
        $this->description = $description;
    }
    /**
     * {@inheritdoc}
     */
    public static function create($body, \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\TypeResolver $typeResolver = null, \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\DescriptionFactory $descriptionFactory = null, \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Types\Context $context = null)
    {
        \_PhpScoperbd5d0c5f7638\Webmozart\Assert\Assert::string($body);
        \_PhpScoperbd5d0c5f7638\Webmozart\Assert\Assert::allNotNull([$typeResolver, $descriptionFactory]);
        list($type, $description) = self::extractTypeFromBody($body);
        $type = $typeResolver->resolve($type, $context);
        $description = $descriptionFactory->create($description, $context);
        return new static($type, $description);
    }
    public function __toString()
    {
        return $this->type . ' ' . $this->description;
    }
}
