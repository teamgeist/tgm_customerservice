<?php
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/***
 *
 * This file is part of the "TgM - Customer Service" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 EG <eg@teamgeist-medien.de>, Teamgeist Medien GbR
 *
 ***/
class TgMUtility {

	const EXT_KEY = 'tgm_customerservice';
	const EXT_DIR_PATH = PATH_site . 'fileadmin/ext/tgm_customerservice';

	private static $emConf = [];

	/**
	 * TODO: Einen anderen Weg finden die Modul-Gruppe umzupositionieren, da dieser nicht gut ist und zu Fehlern führen kann.
	 * TODO: Weiteres hier: https://forge.typo3.org/issues/24949
	 *
	 * @param $groupToMove
	 * @param $after
	 */
	public static function moveBackendModuleGroup($groupToMove, $after) {
		if(trim($after) === '' || empty($after)) {
			return;
		}
		$tgmBeModule = $GLOBALS['TBE_MODULES'][$groupToMove];
		unset($GLOBALS['TBE_MODULES'][$groupToMove]);

		$arrayTop = [];
		$arrayBottom = [];
		$useTop = true;
		foreach ($GLOBALS['TBE_MODULES'] as $moduleKey => $subModules) {
			if($useTop) {
				$arrayTop[$moduleKey] = $subModules;
				if($moduleKey === $after) {
					$arrayTop[$groupToMove] = $tgmBeModule;
					$useTop = false;
				}
			} else {
				$arrayBottom[$moduleKey] = $subModules;
			}
		}

		$GLOBALS['TBE_MODULES'] = array_merge($arrayTop, $arrayBottom);
	}

	/**
	 * Returns the extension configuration settings as an array.
	 *
	 * @return array array
	 */
	public static function getEmConf() {
		if(empty(self::$emConf)) {
			include_once ExtensionManagementUtility::extPath(self::EXT_KEY) . 'ext_emconf.php';
			/** @noinspection PhpUndefinedVariableInspection */
			self::$emConf = $EM_CONF[self::EXT_KEY];
		}
		return self::$emConf;
	}

	/**
	 * Gibt die Extension-Version von "tgm_customerservice" zurück.
	 *
	 * @return string Die Extension-Version
	 */
	public static function getExtVersion() {
		return self::getEmConf()['version'];
	}

	/**
	 * Übergibt den den absoluten Extension-Pfad von "tgm_customerservice".
	 *
	 * @return string Der Extension-Pfad.
	 */
	public static function getExtPath() {
		return ExtensionManagementUtility::extPath(self::EXT_KEY);
	}
}