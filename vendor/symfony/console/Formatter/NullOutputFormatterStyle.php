<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210421\Symfony\Component\Console\Formatter;

/**
 * @author Tien Xuan Vo <tien.xuan.vo@gmail.com>
 */
final class NullOutputFormatterStyle implements \RectorPrefix20210421\Symfony\Component\Console\Formatter\OutputFormatterStyleInterface
{
    /**
     * {@inheritdoc}
     */
    public function apply(string $text) : string
    {
        return $text;
    }
    /**
     * {@inheritdoc}
     * @param string $color
     * @return void
     */
    public function setBackground($color = null)
    {
        // do nothing
    }
    /**
     * {@inheritdoc}
     * @param string $color
     * @return void
     */
    public function setForeground($color = null)
    {
        // do nothing
    }
    /**
     * {@inheritdoc}
     * @return void
     */
    public function setOption(string $option)
    {
        // do nothing
    }
    /**
     * {@inheritdoc}
     * @return void
     */
    public function setOptions(array $options)
    {
        // do nothing
    }
    /**
     * {@inheritdoc}
     * @return void
     */
    public function unsetOption(string $option)
    {
        // do nothing
    }
}
