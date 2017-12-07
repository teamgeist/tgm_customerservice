<?php

use TgM\TgmCustomerservice\Hook\LoginFormHook;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3_MODE') || die('Access denied.');

require_once ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/TgMUtility.php';

if(TYPO3_MODE == 'BE') {
	require_once ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Hook/LoginFormHook.php';

	/**
	 * TODO: Non-existing paths might cause a php error.
	 * TODO: Make link and toolbar editable
	 */
	$topbarIcon = LoginFormHook::getBackendLoginSettings()['style']['topbarIcon'];

	// TBE_STYLES
	if(!is_null($topbarIcon) || !empty(trim($topbarIcon))) {
		$GLOBALS['TBE_STYLES']['logo'] = $topbarIcon;
	}

	// Set topbar logo (backend logo)
	$backendConf = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'];
	if(!isset($backendConf['backendLogo']) || empty(trim($backendConf['backendLogo']))) {
		// unserialize
		$unserializedBackendConf = unserialize($backendConf);
		// add icon
		$unserializedBackendConf['backendLogo'] = $topbarIcon;
		// (re-)serialize
		$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'] = serialize($unserializedBackendConf);
	}

	// Check if backend conf is array. If so, serialize itself
	if(is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'])) {
		$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'] = serialize($topbarIcon);
	}
}

call_user_func(
	function ($_EXTKEY) {
		if(TYPO3_MODE === 'BE') {
			\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
				'TgM.TgmCustomerservice', 'tgmmodulegroup', '', '', [],
				[
					'access' => 'user,group',
					'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/user_mod.png',
					'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be_module.xlf',
				]
			);
			\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
				'TgM.TgmCustomerservice', 'tgmmodulegroup', 'administrationmodule', 'top',
				[
					'AdministrationModule' => 'list',
					'BackendSettings' => 'edit, save, updateFromSettings',
				],
				[
					'access' => 'user,group',
					'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/user_mod.png',
					'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_administrationmodule.xlf',
				]
			);
		}

		TgMUtility::moveBackendModuleGroup('TgmCustomerserviceTgmmodulegroup', 'web');

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'TgM - Customer Service');

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tgmcustomerservice_domain_model_administrationmodule', 'EXT:tgm_customerservice/Resources/Private/Language/locallang_csh_tx_tgmcustomerservice_domain_model_administrationmodule.xlf');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tgmcustomerservice_domain_model_administrationmodule');

	},
	$_EXTKEY
);