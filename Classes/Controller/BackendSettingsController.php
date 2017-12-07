<?php

namespace TgM\TgmCustomerservice\Controller;

use TgM\TgmCustomerservice\Hook\LoginFormHook;
use TgMUtility;
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
		if(!is_dir(TgMUtility::EXT_DIR_PATH)) {
			GeneralUtility::mkdir_deep(TgMUtility::EXT_DIR_PATH);
		}

		$updateFile = $backendSettings['paths']['file'];
		if(!is_null($updateFile)) {
			/**
			 * TRUE = cdn update, FALSE = file update
			 */
			$fileJson = file_get_contents(TgMUtility::isUrl($updateFile) ? $updateFile : PATH_site . $updateFile);
			$backendSettings = json_decode($fileJson, true);
		} else {
			if(file_exists(LoginFormHook::BACKEND_SETTINGS_FILE_PATH)) {
				$backendSettings = json_decode(file_get_contents(LoginFormHook::BACKEND_SETTINGS_FILE_PATH), true);
			}
		}

		/**
		 * TODO: If you clear the system cache and reload the frame while the backend settings are opened, the extension version can not be detected.
		 * TODO: Reloading the frame again (without deleting any cache), it works.
		 */
		$backendSettings['configVersion'] = TgMUtility::EXT_CONFIG_VERSION;
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

		$topbarIconExists = $this->checkTopbarIcon($backendSettings);
		if($topbarIconExists) {
			// Save settings
			file_put_contents(LoginFormHook::BACKEND_SETTINGS_FILE_PATH, json_encode($backendSettings, JSON_PRETTY_PRINT));

			$this->addFlashMessage('Die Daten wurden gespeichert.', 'Erfolgreich', AbstractMessage::OK);
			try {
				$this->redirect('edit', 'BackendSettings', 'TgmCustomerservice', ['backendSettings' => $backendSettings]);
			} catch (\TYPO3\CMS\Extbase\Mvc\Exception $exception) {

			}
		} else {
			$this->addFlashMessage('Der angegebene Pfad für das Topbar-Icon existiert nicht.', 'Hinweis:', AbstractMessage::ERROR);
			try {
				$this->redirect('edit', 'BackendSettings', 'TgmCustomerservice', ['backendSettings' => $backendSettings]);
			} catch (\TYPO3\CMS\Extbase\Mvc\Exception $exception) {

			}
		}
	}

	/**
	 * action updateFromCdn
	 *
	 * @param array $backendSettings
	 *
	 * @return void
	 */
	public function updateFromSettingsAction($backendSettings) {
		$this->addFlashMessage('Die Felder wurden aktualisiert, die Daten jedoch noch nicht gespeichert.', 'Hinweis:', AbstractMessage::WARNING);

		try {
			$this->redirect('edit', 'BackendSettings', 'TgmCustomerservice', ['backendSettings' => $backendSettings]);
		} catch (\TYPO3\CMS\Extbase\Mvc\Exception $exception) {

		}
	}

	/**
	 * Checks if the given topbar icon exists.
	 *
	 * @param $backendSettings array The backend settings.
	 *
	 * @return bool Returns true if the topbar icon exist.
	 */
	private function checkTopbarIcon($backendSettings) {
		if(TgMUtility::isUrl($backendSettings['style']['topbarIcon'])) {
			return false;
		}

		$topbarIconPath = PATH_typo3 . $backendSettings['style']['topbarIcon'];
		if(file_exists($topbarIconPath)) {
			return true;
		}
		return false;
	}
}