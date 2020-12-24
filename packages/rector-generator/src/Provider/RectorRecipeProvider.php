<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RectorGenerator\Provider;

use _PhpScopere8e811afab72\Rector\RectorGenerator\Exception\ConfigurationException;
use _PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe;
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
    public function __construct(?\_PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe = null)
    {
        $this->rectorRecipe = $rectorRecipe;
    }
    public function provide() : \_PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe
    {
        if ($this->rectorRecipe === null) {
            throw new \_PhpScopere8e811afab72\Rector\RectorGenerator\Exception\ConfigurationException(self::MESSAGE);
        }
        return $this->rectorRecipe;
    }
}
