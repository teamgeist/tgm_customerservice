<?php

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
	const EXT_CONFIG_VERSION = 1;

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
}