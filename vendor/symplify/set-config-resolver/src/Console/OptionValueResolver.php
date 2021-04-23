<?php

declare (strict_types=1);
namespace RectorPrefix20210423\Symplify\SetConfigResolver\Console;

use RectorPrefix20210423\Symfony\Component\Console\Input\InputInterface;
final class OptionValueResolver
{
    /**
     * @param string[] $optionNames
     * @return string|null
     */
    public function getOptionValue(\RectorPrefix20210423\Symfony\Component\Console\Input\InputInterface $input, array $optionNames)
    {
        foreach ($optionNames as $optionName) {
            if ($input->hasParameterOption($optionName, \true)) {
                return $input->getParameterOption($optionName, null, \true);
            }
        }
        return null;
    }
}
