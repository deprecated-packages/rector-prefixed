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
namespace _PhpScoperabd03f0baf05\phpDocumentor\Reflection\DocBlock\Tags;

use _PhpScoperabd03f0baf05\phpDocumentor\Reflection\DocBlock\Description;
use _PhpScoperabd03f0baf05\phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use _PhpScoperabd03f0baf05\phpDocumentor\Reflection\Fqsen;
use _PhpScoperabd03f0baf05\phpDocumentor\Reflection\FqsenResolver;
use _PhpScoperabd03f0baf05\phpDocumentor\Reflection\Types\Context as TypeContext;
use _PhpScoperabd03f0baf05\Webmozart\Assert\Assert;
/**
 * Reflection class for a {@}uses tag in a Docblock.
 */
final class Uses extends \_PhpScoperabd03f0baf05\phpDocumentor\Reflection\DocBlock\Tags\BaseTag implements \_PhpScoperabd03f0baf05\phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod
{
    protected $name = 'uses';
    /** @var Fqsen */
    protected $refers = null;
    /**
     * Initializes this tag.
     *
     * @param Fqsen       $refers
     * @param Description $description
     */
    public function __construct(\_PhpScoperabd03f0baf05\phpDocumentor\Reflection\Fqsen $refers, \_PhpScoperabd03f0baf05\phpDocumentor\Reflection\DocBlock\Description $description = null)
    {
        $this->refers = $refers;
        $this->description = $description;
    }
    /**
     * {@inheritdoc}
     */
    public static function create($body, \_PhpScoperabd03f0baf05\phpDocumentor\Reflection\FqsenResolver $resolver = null, \_PhpScoperabd03f0baf05\phpDocumentor\Reflection\DocBlock\DescriptionFactory $descriptionFactory = null, \_PhpScoperabd03f0baf05\phpDocumentor\Reflection\Types\Context $context = null)
    {
        \_PhpScoperabd03f0baf05\Webmozart\Assert\Assert::string($body);
        \_PhpScoperabd03f0baf05\Webmozart\Assert\Assert::allNotNull([$resolver, $descriptionFactory]);
        $parts = \preg_split('/\\s+/Su', $body, 2);
        return new static($resolver->resolve($parts[0], $context), $descriptionFactory->create(isset($parts[1]) ? $parts[1] : '', $context));
    }
    /**
     * Returns the structural element this tag refers to.
     *
     * @return Fqsen
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
        return $this->refers . ' ' . $this->description->render();
    }
}
