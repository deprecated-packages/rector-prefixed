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
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Tags\Reference\Fqsen as FqsenRef;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\FqsenResolver;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Types\Context as TypeContext;
use _PhpScoperbd5d0c5f7638\Webmozart\Assert\Assert;
/**
 * Reflection class for an {@}see tag in a Docblock.
 */
class See extends \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Tags\BaseTag implements \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod
{
    protected $name = 'see';
    /** @var Reference */
    protected $refers = null;
    /**
     * Initializes this tag.
     *
     * @param Reference $refers
     * @param Description $description
     */
    public function __construct(\_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference $refers, \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Description $description = null)
    {
        $this->refers = $refers;
        $this->description = $description;
    }
    /**
     * {@inheritdoc}
     */
    public static function create($body, \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\FqsenResolver $resolver = null, \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\DescriptionFactory $descriptionFactory = null, \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Types\Context $context = null)
    {
        \_PhpScoperbd5d0c5f7638\Webmozart\Assert\Assert::string($body);
        \_PhpScoperbd5d0c5f7638\Webmozart\Assert\Assert::allNotNull([$resolver, $descriptionFactory]);
        $parts = \preg_split('/\\s+/Su', $body, 2);
        $description = isset($parts[1]) ? $descriptionFactory->create($parts[1], $context) : null;
        // https://tools.ietf.org/html/rfc2396#section-3
        if (\preg_match('/\\w:\\/\\/\\w/i', $parts[0])) {
            return new static(new \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Tags\Reference\Url($parts[0]), $description);
        }
        return new static(new \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Tags\Reference\Fqsen($resolver->resolve($parts[0], $context)), $description);
    }
    /**
     * Returns the ref of this tag.
     *
     * @return Reference
     */
    public function getReference()
    {
        return $this->refers;
    }
    /**
     * Returns a string representation of this tag.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->refers . ($this->description ? ' ' . $this->description->render() : '');
    }
}
