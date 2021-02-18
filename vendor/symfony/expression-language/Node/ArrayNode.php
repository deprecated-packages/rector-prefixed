<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210218\Symfony\Component\ExpressionLanguage\Node;

use RectorPrefix20210218\Symfony\Component\ExpressionLanguage\Compiler;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @internal
 */
class ArrayNode extends \RectorPrefix20210218\Symfony\Component\ExpressionLanguage\Node\Node
{
    protected $index;
    public function __construct()
    {
        $this->index = -1;
    }
    public function addElement(\RectorPrefix20210218\Symfony\Component\ExpressionLanguage\Node\Node $value, \RectorPrefix20210218\Symfony\Component\ExpressionLanguage\Node\Node $key = null)
    {
        if (null === $key) {
            $key = new \RectorPrefix20210218\Symfony\Component\ExpressionLanguage\Node\ConstantNode(++$this->index);
        }
        \array_push($this->nodes, $key, $value);
    }
    /**
     * Compiles the node to PHP.
     */
    public function compile(\RectorPrefix20210218\Symfony\Component\ExpressionLanguage\Compiler $compiler)
    {
        $compiler->raw('[');
        $this->compileArguments($compiler);
        $compiler->raw(']');
    }
    public function evaluate(array $functions, array $values)
    {
        $result = [];
        foreach ($this->getKeyValuePairs() as $pair) {
            $result[$pair['key']->evaluate($functions, $values)] = $pair['value']->evaluate($functions, $values);
        }
        return $result;
    }
    public function toArray()
    {
        $value = [];
        foreach ($this->getKeyValuePairs() as $pair) {
            $value[$pair['key']->attributes['value']] = $pair['value'];
        }
        $array = [];
        if ($this->isHash($value)) {
            foreach ($value as $k => $v) {
                $array[] = ', ';
                $array[] = new \RectorPrefix20210218\Symfony\Component\ExpressionLanguage\Node\ConstantNode($k);
                $array[] = ': ';
                $array[] = $v;
            }
            $array[0] = '{';
            $array[] = '}';
        } else {
            foreach ($value as $v) {
                $array[] = ', ';
                $array[] = $v;
            }
            $array[0] = '[';
            $array[] = ']';
        }
        return $array;
    }
    protected function getKeyValuePairs()
    {
        $pairs = [];
        foreach (\array_chunk($this->nodes, 2) as $pair) {
            $pairs[] = ['key' => $pair[0], 'value' => $pair[1]];
        }
        return $pairs;
    }
    protected function compileArguments(\RectorPrefix20210218\Symfony\Component\ExpressionLanguage\Compiler $compiler, $withKeys = \true)
    {
        $first = \true;
        foreach ($this->getKeyValuePairs() as $pair) {
            if (!$first) {
                $compiler->raw(', ');
            }
            $first = \false;
            if ($withKeys) {
                $compiler->compile($pair['key'])->raw(' => ');
            }
            $compiler->compile($pair['value']);
        }
    }
}
