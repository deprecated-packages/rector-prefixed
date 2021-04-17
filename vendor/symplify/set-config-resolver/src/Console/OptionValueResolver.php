<?php

declare (strict_types=1);
namespace RectorPrefix20210417\Symplify\SetConfigResolver\Console;

use RectorPrefix20210417\Symfony\Component\Console\Input\InputInterface;
final class OptionValueResolver
{
    /**
     * @param string[] $optionNames
     */
    public function getOptionValue(\RectorPrefix20210417\Symfony\Component\Console\Input\InputInterface $input, array $optionNames) : ?string
    {
        foreach ($optionNames as $optionName) {
            if ($input->hasParameterOption($optionName, \true)) {
                return $input->getParameterOption($optionName, null, \true);
            }
        }
        return null;
    }
}
