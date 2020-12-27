<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _HumbugBox221ad6f1b81f\Symfony\Component\Console\Helper;

use _HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputAwareInterface;
use _HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputInterface;
/**
 * An implementation of InputAwareInterface for Helpers.
 *
 * @author Wouter J <waldio.webdesign@gmail.com>
 */
abstract class InputAwareHelper extends \_HumbugBox221ad6f1b81f\Symfony\Component\Console\Helper\Helper implements \_HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputAwareInterface
{
    protected $input;
    /**
     * {@inheritdoc}
     */
    public function setInput(\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputInterface $input)
    {
        $this->input = $input;
    }
}
