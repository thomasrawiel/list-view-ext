<?php
declare(strict_types=1);

namespace TRAW\ListViewExt\Hooks;

class ListViewPostProcessor
{
    public function postProcessValue(array $params): string
    {
        $value = $params['value'] ?? '';
        $conf = $params['colConf'] ?? [];

        if (($conf['renderType'] ?? null) !== 'checkboxLabeledToggle') {
            return $value;
        }
        $labelChecked = $conf['items'][0]['labelChecked'] ?? 'Enabled';
        $labelUnchecked = $conf['items'][0]['labelUnchecked'] ?? 'Disabled';

        if ($value === 'Yes' || $value === '1' || $value === 1) {
            return $labelChecked;
        }

        return $labelUnchecked;
    }
}
