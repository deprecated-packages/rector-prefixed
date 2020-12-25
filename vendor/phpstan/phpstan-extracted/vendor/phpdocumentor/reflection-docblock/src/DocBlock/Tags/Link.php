<?php

/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @author    Ben Selby <benmatselby@gmail.com>
 * @copyright 2010-2011 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */
namespace _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags;

use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Description;
use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context as TypeContext;
use _HumbugBox221ad6f1b81f\Webmozart\Assert\Assert;
/**
 * Reflection class for a @link tag in a Docblock.
 */
final class Link extends \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\BaseTag implements \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod
{
    protected $name = 'link';
    /** @var string */
    private $link = '';
    /**
     * Initializes a link to a URL.
     *
     * @param string      $link
     * @param Description $description
     */
    public function __construct($link, \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Description $description = null)
    {
        \_HumbugBox221ad6f1b81f\Webmozart\Assert\Assert::string($link);
        $this->link = $link;
        $this->description = $description;
    }
    /**
     * {@inheritdoc}
     */
    public static function create($body, \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\DescriptionFactory $descriptionFactory = null, \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context $context = null)
    {
        \_HumbugBox221ad6f1b81f\Webmozart\Assert\Assert::string($body);
        \_HumbugBox221ad6f1b81f\Webmozart\Assert\Assert::notNull($descriptionFactory);
        $parts = \preg_split('/\\s+/Su', $body, 2);
        $description = isset($parts[1]) ? $descriptionFactory->create($parts[1], $context) : null;
        return new static($parts[0], $description);
    }
    /**
     * Gets the link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }
    /**
     * Returns a string representation for this tag.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->link . ($this->description ? ' ' . $this->description->render() : '');
    }
}
