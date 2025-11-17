<?php
declare(strict_types=1);

namespace TRAW\ListViewExt\Hooks;

use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;

class ListViewPostProcessor
{
    public function __construct(
        private readonly LanguageServiceFactory $languageServiceFactory,
    )
    {
    }

    public function postProcessValue(array $params): string
    {
        $value = $params['value'] ?? '';
        $conf = $params['colConf'] ?? [];

        if ($conf['type'] !== 'check') {
            return $value;
        }

        if (empty($conf['items'])) {
            return $value;
        }

        if (count($conf['items']) === 1) {
            $labelChecked = $this->translate(
                $conf['items'][0]['labelChecked']
                ?? $conf['items'][0]['label']
                ?? 'LLL:EXT:core/Resources/Private/Language/locallang_common.xlf:enabled'
            );
            $labelUnchecked = $this->translate(
                $conf['items'][0]['labelUnchecked']
                ?? 'LLL:EXT:core/Resources/Private/Language/locallang_common.xlf:disabled');

            if ($value === $this->translate('LLL:EXT:core/Resources/Private/Language/locallang_common.xlf:yes')) {
                return $labelChecked;
            }

            if (($conf['renderType'] ?? null) === 'checkboxLabeledToggle') {
                return $labelUnchecked;
            }
        }

        //        if (count($conf['items']) > 1 && $conf['renderType'] === 'checkboxLabeledToggle') {
//            foreach ($conf['items'] as $index => $itemConf) {
//                $itemValue = $this->getMultipleCheckboxValue($value, $index);
//
//                $labelChecked = $this->translate($itemConf['labelChecked'] ?? $itemConf['label'] ?? 'Enabled');
//                $labelUnchecked = $this->translate($itemConf['labelUnchecked'] ?? 'Disabled');
//
//                $labels[] = ($itemValue ? $labelChecked : $labelUnchecked);
//            }
//            return implode(', ', $labels);
//        }

        return $value;
    }

    private function getMultipleCheckboxValue($value, $index)
    {
//todo
    }

    private function translate(string $input): string
    {
        return $this->getLanguageService()->sL($input);
    }

    private function getLanguageService(): LanguageService
    {
        return $this->languageServiceFactory
            ->createFromUserPreferences($this->getBackendUserAuthentication());
    }

    private function getBackendUserAuthentication(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
