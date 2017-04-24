<?php

namespace TgM\TgmCustomerservice\Controller;

use TgM\TgmCustomerservice\Hook\LoginFormHook;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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

/**
 * BackendSettingsController
 *
 * TODO: Prüfen, ob die Update-Datei (bzw. die angegebene URL) existiert.
 */
class BackendSettingsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * backendSettingsRepository
	 *
	 * @var \TgM\TgmCustomerservice\Domain\Repository\BackendSettingsRepository
	 * @inject
	 */
	protected $backendSettingsRepository = null;

	/**
	 * action edit
	 *
	 * @param array $backendSettings
	 *
	 * @return void
	 */
	public function editAction($backendSettings = null) {

		/**
		 * Prüft, ob der Extension-Pfad existiert.
		 * Wenn nicht, wird er erstellt.
		 */
		if(!is_dir(\TgMUtility::EXT_DIR_PATH)) {
			GeneralUtility::mkdir_deep(\TgMUtility::EXT_DIR_PATH);
		}

		$updateFile = $backendSettings['paths']['file'];
		if(!is_null($updateFile)) {

			/**
			 * TRUE = CDN-Update, FALSE = Datei-Update
			 */
			$isCdnUpdate = preg_match('/^(http[s]?:\/\/)/', $updateFile);
			$fileJson = file_get_contents($isCdnUpdate ? $updateFile : PATH_site . $updateFile);

			$backendSettings = json_decode($fileJson, true);
		} else {
			if(file_exists(LoginFormHook::BACKEND_SETTINGS_FILE_PATH)) {
				$backendSettings = json_decode(file_get_contents(LoginFormHook::BACKEND_SETTINGS_FILE_PATH), true);
			}
		}

		$backendSettings['extVersion'] = \TgMUtility::getExtVersion();
		$this->view->assign('backendSettings', $backendSettings);
	}

	/**
	 * action save
	 *
	 * @param array $backendSettings
	 *
	 * @return void
	 */
	public function saveAction($backendSettings) {
		file_put_contents(LoginFormHook::BACKEND_SETTINGS_FILE_PATH, json_encode($backendSettings, JSON_PRETTY_PRINT));

		$this->addFlashMessage('Die Daten wurden gespeichert.', 'Erfolgreich', AbstractMessage::OK);
		$this->redirect('edit', 'BackendSettings', 'TgmCustomerservice', ['backendSettings' => $backendSettings]);
	}

	/**
	 * action updateFromCdn
	 *
	 * @param array $backendSettings
	 *
	 * @return void
	 */
	public function updateFromSettingsAction($backendSettings) {
		$this->addFlashMessage('Die Felder wurden aktualisiert, die Daten jedoch noch nicht gespeichert.', 'Hinweis', AbstractMessage::WARNING);
		$this->redirect('edit', 'BackendSettings', 'TgmCustomerservice', ['backendSettings' => $backendSettings]);
	}
}