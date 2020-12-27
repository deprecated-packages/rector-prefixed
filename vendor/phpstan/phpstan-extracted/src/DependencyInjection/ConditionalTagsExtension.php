<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\DependencyInjection;

use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Schema\Expect;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierFactory;
use RectorPrefix20201227\PHPStan\Broker\BrokerFactory;
use RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolverExtension;
use RectorPrefix20201227\PHPStan\Rules\RegistryFactory;
class ConditionalTagsExtension extends \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        $bool = \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::bool();
        return \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::arrayOf(\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::structure([\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::PROPERTIES_CLASS_REFLECTION_EXTENSION_TAG => $bool, \RectorPrefix20201227\PHPStan\Broker\BrokerFactory::METHODS_CLASS_REFLECTION_EXTENSION_TAG => $bool, \RectorPrefix20201227\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG => $bool, \RectorPrefix20201227\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG => $bool, \RectorPrefix20201227\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG => $bool, \RectorPrefix20201227\PHPStan\Broker\BrokerFactory::OPERATOR_TYPE_SPECIFYING_EXTENSION_TAG => $bool, \RectorPrefix20201227\PHPStan\Rules\RegistryFactory::RULE_TAG => $bool, \RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolverExtension::EXTENSION_TAG => $bool, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierFactory::FUNCTION_TYPE_SPECIFYING_EXTENSION_TAG => $bool, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierFactory::METHOD_TYPE_SPECIFYING_EXTENSION_TAG => $bool, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierFactory::STATIC_METHOD_TYPE_SPECIFYING_EXTENSION_TAG => $bool])->min(1));
    }
    public function beforeCompile() : void
    {
        /** @var mixed[] $config */
        $config = $this->config;
        $builder = $this->getContainerBuilder();
        foreach ($config as $type => $tags) {
            $services = $builder->findByType($type);
            if (\count($services) === 0) {
                throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException(\sprintf('No services of type "%s" found.', $type));
            }
            foreach ($services as $service) {
                foreach ($tags as $tag => $parameter) {
                    if ((bool) $parameter) {
                        $service->addTag($tag);
                        continue;
                    }
                }
            }
        }
    }
}
