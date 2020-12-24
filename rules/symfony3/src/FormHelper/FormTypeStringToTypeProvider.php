<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony3\FormHelper;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Rector\Symfony\ServiceMapProvider;
final class FormTypeStringToTypeProvider
{
    /**
     * @var array<string, string>
     */
    private const SYMFONY_CORE_NAME_TO_TYPE_MAP = ['form' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\FormType', 'birthday' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\BirthdayType', 'checkbox' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CheckboxType', 'collection' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CollectionType', 'country' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CountryType', 'currency' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CurrencyType', 'date' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\DateType', 'datetime' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\DatetimeType', 'email' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\EmailType', 'file' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\FileType', 'hidden' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\HiddenType', 'integer' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\IntegerType', 'language' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\LanguageType', 'locale' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\LocaleType', 'money' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\MoneyType', 'number' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\NumberType', 'password' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\PasswordType', 'percent' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\PercentType', 'radio' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\RadioType', 'range' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\RangeType', 'repeated' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\RepeatedType', 'search' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\SearchType', 'textarea' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TextareaType', 'text' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', 'time' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TimeType', 'timezone' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TimezoneType', 'url' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\UrlType', 'button' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\ButtonType', 'submit' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\SubmitType', 'reset' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\ResetType', 'entity' => '_PhpScopere8e811afab72\\Symfony\\Bridge\\Doctrine\\Form\\Type\\EntityType', 'choice' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType'];
    /**
     * @var array<string, string>
     */
    private $customServiceFormTypeByAlias = [];
    /**
     * @var ServiceMapProvider
     */
    private $serviceMapProvider;
    public function __construct(\_PhpScopere8e811afab72\Rector\Symfony\ServiceMapProvider $serviceMapProvider)
    {
        $this->serviceMapProvider = $serviceMapProvider;
    }
    public function matchClassForNameWithPrefix(string $name) : ?string
    {
        $nameToTypeMap = $this->getNameToTypeMap();
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::startsWith($name, 'form.type.')) {
            $name = \_PhpScopere8e811afab72\Nette\Utils\Strings::substring($name, \strlen('form.type.'));
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
