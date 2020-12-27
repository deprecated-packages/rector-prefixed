<?php

declare (strict_types=1);
namespace Rector\Symfony3\FormHelper;

use RectorPrefix20201227\Nette\Utils\Strings;
use Rector\Symfony\ServiceMapProvider;
final class FormTypeStringToTypeProvider
{
    /**
     * @var array<string, string>
     */
    private const SYMFONY_CORE_NAME_TO_TYPE_MAP = ['form' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\FormType', 'birthday' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\BirthdayType', 'checkbox' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CheckboxType', 'collection' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CollectionType', 'country' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CountryType', 'currency' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CurrencyType', 'date' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\DateType', 'datetime' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\DatetimeType', 'email' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\EmailType', 'file' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\FileType', 'hidden' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\HiddenType', 'integer' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\IntegerType', 'language' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\LanguageType', 'locale' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\LocaleType', 'money' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\MoneyType', 'number' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\NumberType', 'password' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\PasswordType', 'percent' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\PercentType', 'radio' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\RadioType', 'range' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\RangeType', 'repeated' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\RepeatedType', 'search' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\SearchType', 'textarea' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TextareaType', 'text' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', 'time' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TimeType', 'timezone' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TimezoneType', 'url' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\UrlType', 'button' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\ButtonType', 'submit' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\SubmitType', 'reset' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\ResetType', 'entity' => 'RectorPrefix20201227\\Symfony\\Bridge\\Doctrine\\Form\\Type\\EntityType', 'choice' => 'RectorPrefix20201227\\Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType'];
    /**
     * @var array<string, string>
     */
    private $customServiceFormTypeByAlias = [];
    /**
     * @var ServiceMapProvider
     */
    private $serviceMapProvider;
    public function __construct(\Rector\Symfony\ServiceMapProvider $serviceMapProvider)
    {
        $this->serviceMapProvider = $serviceMapProvider;
    }
    public function matchClassForNameWithPrefix(string $name) : ?string
    {
        $nameToTypeMap = $this->getNameToTypeMap();
        if (\RectorPrefix20201227\Nette\Utils\Strings::startsWith($name, 'form.type.')) {
            $name = \RectorPrefix20201227\Nette\Utils\Strings::substring($name, \strlen('form.type.'));
        }
        return $nameToTypeMap[$name] ?? null;
    }
    /**
     * @return array<string, string>
     */
    private function getNameToTypeMap() : array
    {
        $customServiceFormTypeByAlias = $this->provideCustomServiceFormTypeByAliasFromContainerXml();
        return \array_merge(self::SYMFONY_CORE_NAME_TO_TYPE_MAP, $customServiceFormTypeByAlias);
    }
    /**
     * @return array<string, string>
     */
    private function provideCustomServiceFormTypeByAliasFromContainerXml() : array
    {
        if ($this->customServiceFormTypeByAlias !== []) {
            return $this->customServiceFormTypeByAlias;
        }
        $serviceMap = $this->serviceMapProvider->provide();
        $formTypeServiceDefinitions = $serviceMap->getServicesByTag('form.type');
        foreach ($formTypeServiceDefinitions as $formTypeServiceDefinition) {
            $formTypeTag = $formTypeServiceDefinition->getTag('form.type');
            if ($formTypeTag === null) {
                continue;
            }
            $alias = $formTypeTag->getData()['alias'] ?? null;
            if (!\is_string($alias)) {
                continue;
            }
            $class = $formTypeServiceDefinition->getClass();
            if ($class === null) {
                continue;
            }
            $this->customServiceFormTypeByAlias[$alias] = $class;
        }
        return $this->customServiceFormTypeByAlias;
    }
}
