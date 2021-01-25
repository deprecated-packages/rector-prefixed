<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210125\Symfony\Component\ExpressionLanguage\Node;

use RectorPrefix20210125\Symfony\Component\ExpressionLanguage\Compiler;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @internal
 */
class ArgumentsNode extends \RectorPrefix20210125\Symfony\Component\ExpressionLanguage\Node\ArrayNode
{
    public function compile(\RectorPrefix20210125\Symfony\Component\ExpressionLanguage\Compiler $compiler)
    {
        $this->compileArguments($compiler, \false);
    }
    public function toArray()
    {
        $array = [];
        foreach ($this->getKeyValuePairs() as $pair) {
            $array[] = $pair['value'];
            $array[] = ', ';
        }
        \array_pop($array);
        return $array;
    }
}
