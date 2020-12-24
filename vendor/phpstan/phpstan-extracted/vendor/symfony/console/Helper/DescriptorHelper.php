<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Helper;

use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Descriptor\DescriptorInterface;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Descriptor\JsonDescriptor;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Descriptor\MarkdownDescriptor;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Descriptor\TextDescriptor;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Descriptor\XmlDescriptor;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Exception\InvalidArgumentException;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface;
/**
 * This class adds helper method to describe objects in various formats.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class DescriptorHelper extends \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Helper\Helper
{
    /**
     * @var DescriptorInterface[]
     */
    private $descriptors = [];
    public function __construct()
    {
        $this->register('txt', new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Descriptor\TextDescriptor())->register('xml', new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Descriptor\XmlDescriptor())->register('json', new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Descriptor\JsonDescriptor())->register('md', new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Descriptor\MarkdownDescriptor());
    }
    /**
     * Describes an object if supported.
     *
     * Available options are:
     * * format: string, the output format name
     * * raw_text: boolean, sets output type as raw
     *
     * @param object $object
     *
     * @throws InvalidArgumentException when the given format is not supported
     */
    public function describe(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface $output, $object, array $options = [])
    {
        $options = \array_merge(['raw_text' => \false, 'format' => 'txt'], $options);
        if (!isset($this->descriptors[$options['format']])) {
            throw new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Exception\InvalidArgumentException(\sprintf('Unsupported format "%s".', $options['format']));
        }
        $descriptor = $this->descriptors[$options['format']];
        $descriptor->describe($output, $object, $options);
    }
    /**
     * Registers a descriptor.
     *
     * @param string $format
     *
     * @return $this
     */
    public function register($format, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Descriptor\DescriptorInterface $descriptor)
    {
        $this->descriptors[$format] = $descriptor;
        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'descriptor';
    }
}
