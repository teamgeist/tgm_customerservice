<?php

use TgM\TgmCustomerservice\Hook\LoginFormHook;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

defined('TYPO3_MODE') || die('Access denied.');

require_once ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/TgMUtility.php';

// user func
call_user_func(
	function ($extKey) {
		if(TYPO3_MODE === 'BE') {
			\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
				'TgM.TgmCustomerservice', 'tgmmodulegroup', '', '', [],
				[
					'access' => 'user,group',
					'icon' => 'EXT:' . $extKey . '/Resources/Public/Icons/user_mod.png',
					'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be_module.xlf',
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
					'icon' => 'EXT:' . $extKey . '/Resources/Public/Icons/user_mod.png',
					'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_administrationmodule.xlf',
				]
			);
		}

		TgMUtility::moveBackendModuleGroup('TgmCustomerserviceTgmmodulegroup', 'web');

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'TgM - Customer Service');

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tgmcustomerservice_domain_model_administrationmodule', 'EXT:tgm_customerservice/Resources/Private/Language/locallang_csh_tx_tgmcustomerservice_domain_model_administrationmodule.xlf');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tgmcustomerservice_domain_model_administrationmodule');

	},
	$_EXTKEY
);