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
namespace _PhpScopera143bcca66cb\phpDocumentor\Reflection\DocBlock\Tags;

use _PhpScopera143bcca66cb\phpDocumentor\Reflection\DocBlock\Description;
use _PhpScopera143bcca66cb\phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use _PhpScopera143bcca66cb\phpDocumentor\Reflection\Type;
use _PhpScopera143bcca66cb\phpDocumentor\Reflection\TypeResolver;
use _PhpScopera143bcca66cb\phpDocumentor\Reflection\Types\Context as TypeContext;
use _PhpScopera143bcca66cb\Webmozart\Assert\Assert;
/**
 * Reflection class for a {@}throws tag in a Docblock.
 */
final class Throws extends \_PhpScopera143bcca66cb\phpDocumentor\Reflection\DocBlock\Tags\TagWithType implements \_PhpScopera143bcca66cb\phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod
{
    public function __construct(\_PhpScopera143bcca66cb\phpDocumentor\Reflection\Type $type, \_PhpScopera143bcca66cb\phpDocumentor\Reflection\DocBlock\Description $description = null)
    {
        $this->name = 'throws';
        $this->type = $type;
        $this->description = $description;
    }
    /**
     * {@inheritdoc}
     */
    public static function create($body, \_PhpScopera143bcca66cb\phpDocumentor\Reflection\TypeResolver $typeResolver = null, \_PhpScopera143bcca66cb\phpDocumentor\Reflection\DocBlock\DescriptionFactory $descriptionFactory = null, \_PhpScopera143bcca66cb\phpDocumentor\Reflection\Types\Context $context = null)
    {
        \_PhpScopera143bcca66cb\Webmozart\Assert\Assert::string($body);
        \_PhpScopera143bcca66cb\Webmozart\Assert\Assert::allNotNull([$typeResolver, $descriptionFactory]);
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
