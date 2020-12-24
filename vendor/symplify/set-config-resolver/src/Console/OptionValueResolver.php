<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Console;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputInterface;
final class OptionValueResolver
{
    /**
     * @param string[] $optionNames
     */
    public function getOptionValue(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputInterface $input, array $optionNames) : ?string
    {
        foreach ($optionNames as $optionName) {
            if ($input->hasParameterOption($optionName, \true)) {
                return $input->getParameterOption($optionName, null, \true);
            }
        }
        return null;
    }
}
