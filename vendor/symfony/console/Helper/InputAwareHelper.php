<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper50d83356d739\Symfony\Component\Console\Helper;

use _PhpScoper50d83356d739\Symfony\Component\Console\Input\InputAwareInterface;
use _PhpScoper50d83356d739\Symfony\Component\Console\Input\InputInterface;
/**
 * An implementation of InputAwareInterface for Helpers.
 *
 * @author Wouter J <waldio.webdesign@gmail.com>
 */
abstract class InputAwareHelper extends \_PhpScoper50d83356d739\Symfony\Component\Console\Helper\Helper implements \_PhpScoper50d83356d739\Symfony\Component\Console\Input\InputAwareInterface
{
    protected $input;
    /**
     * {@inheritdoc}
     */
    public function setInput(\_PhpScoper50d83356d739\Symfony\Component\Console\Input\InputInterface $input)
    {
        $this->input = $input;
    }
}
