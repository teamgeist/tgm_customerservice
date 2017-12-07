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
	const EXT_DIR_PATH = PATH_site . 'fileadmin/ext/' . self::EXT_KEY;
	const EXT_CONFIG_VERSION = 1;

	/**
	 * TODO: Find another way to re-sort module groups. See https://forge.typo3.org/issues/24949
	 *
	 * @param $groupToMove string The group to move.
	 * @param $after string Insert the given group after...
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
	 * Checks if the given string is an url or not. (quick check)
	 *
	 * @param $string
	 *
	 * @return false|int
	 */
	public static function isUrl($string) {
		return preg_match('/^(http[s]?:\/\/)/', $string);
	}
}