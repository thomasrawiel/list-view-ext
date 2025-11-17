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
    ) {}

    public function postProcessValue(array $params): string
    {
        $value = $params['value'] ?? '';
        $conf = $params['colConf'] ?? [];

        if (($conf['renderType'] ?? null) !== 'checkboxLabeledToggle') {
            return $value;
        }
        $labelChecked = $this->translate($conf['items'][0]['labelChecked'] ?? 'Enabled');
        $labelUnchecked = $this->translate($conf['items'][0]['labelUnchecked'] ?? 'Disabled');

        if ($value === 'Yes' || $value === '1' || $value === 1) {
            return $labelChecked;
        }

        return $labelUnchecked;
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
