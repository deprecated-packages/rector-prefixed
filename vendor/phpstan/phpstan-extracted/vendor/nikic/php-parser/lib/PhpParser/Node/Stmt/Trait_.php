<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;

use _PhpScoperb75b35f52b74\PhpParser\Node;
class Trait_ extends \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike
{
    /**
     * Constructs a trait node.
     *
     * @param string|Node\Identifier $name Name
     * @param array  $subNodes   Array of the following optional subnodes:
     *                           'stmts'      => array(): Statements
     *                           'attrGroups' => array(): PHP attribute groups
     * @param array  $attributes Additional attributes
     */
    public function __construct($name, array $subNodes = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->name = \is_string($name) ? new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($name) : $name;
        $this->stmts = $subNodes['stmts'] ?? [];
        $this->attrGroups = $subNodes['attrGroups'] ?? [];
    }
    public function getSubNodeNames() : array
    {
        return ['attrGroups', 'name', 'stmts'];
    }
    public function getType() : string
    {
        return 'Stmt_Trait';
    }
}
