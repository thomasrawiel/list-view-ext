<?php

defined('TYPO3') || die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['postProcessValue'][\Vendor\Extension\Hooks\LabeledCheckboxListViewHook::class]
    = \TRAW\ListViewExt\Hooks\ListViewPostProcessor::class . '->postProcessValue';
