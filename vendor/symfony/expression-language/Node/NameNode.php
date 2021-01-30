<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210130\Symfony\Component\ExpressionLanguage\Node;

use RectorPrefix20210130\Symfony\Component\ExpressionLanguage\Compiler;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @internal
 */
class NameNode extends \RectorPrefix20210130\Symfony\Component\ExpressionLanguage\Node\Node
{
    public function __construct(string $name)
    {
        parent::__construct([], ['name' => $name]);
    }
    public function compile(\RectorPrefix20210130\Symfony\Component\ExpressionLanguage\Compiler $compiler)
    {
        $compiler->raw('$' . $this->attributes['name']);
    }
    public function evaluate(array $functions, array $values)
    {
        return $values[$this->attributes['name']];
    }
    public function toArray()
    {
        return [$this->attributes['name']];
    }
}
