<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\RectorGenerator\Provider;

use _PhpScoper0a2ac50786fa\Rector\RectorGenerator\Exception\ConfigurationException;
use _PhpScoper0a2ac50786fa\Rector\RectorGenerator\ValueObject\RectorRecipe;
final class RectorRecipeProvider
{
    /**
     * @var string
     */
    private const MESSAGE = 'Make sure the "rector-recipe.php" config file is imported and parameter set. Are you sure its in your main config?';
    /**
     * @var RectorRecipe|null
     */
    private $rectorRecipe;
    /**
     * Parameter must be configured in the rector config
     */
    public function __construct(?\_PhpScoper0a2ac50786fa\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe = null)
    {
        $this->rectorRecipe = $rectorRecipe;
    }
    public function provide() : \_PhpScoper0a2ac50786fa\Rector\RectorGenerator\ValueObject\RectorRecipe
    {
        if ($this->rectorRecipe === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\RectorGenerator\Exception\ConfigurationException(self::MESSAGE);
        }
        return $this->rectorRecipe;
    }
}
