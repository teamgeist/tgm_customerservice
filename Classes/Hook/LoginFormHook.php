<?php

namespace TgM\TgmCustomerservice\Hook;

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

use TYPO3\CMS\Backend\Controller\LoginController;
use TYPO3\CMS\Backend\LoginProvider\UsernamePasswordLoginProvider;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Registers login template for the current domain
 */
class LoginFormHook extends UsernamePasswordLoginProvider {

	/**
	 * Direkt-Pfad zur Datei
	 */
	const BACKEND_SETTINGS_FILE_PATH = \TgMUtility::EXT_DIR_PATH . '/backendsettings.json';

	/**
	 * @param StandaloneView  $view
	 * @param PageRenderer    $pageRenderer
	 * @param LoginController $loginController
	 */
	public function render(StandaloneView $view, PageRenderer $pageRenderer, LoginController $loginController) {
		parent::render($view, $pageRenderer, $loginController);

		$backendLoginSettings = self::getBackendLoginSettings();

		$view->setLayoutRootPaths([\TgMUtility::getExtPath() . 'Resources/Private/Backend/Layouts']);
		$highlightColor = $backendLoginSettings['style']['highlightColor'];
		$customCSS = '
			img.typo3-login-image { max-width: 150px; }
			.btn-login, .btn-login:active, .btn-login:active:focus, .btn-login:active:hover,
				.btn-login:focus, .btn-login:hover, .btn-login:visited,				
				.btn-login.disabled:hover, .btn-login[disabled]:hover, fieldset[disabled] .btn-login:hover,
				.btn-login.disabled:focus, .btn-login[disabled]:focus, fieldset[disabled] .btn-login:focus,
				.btn-login.disabled.focus, .btn-login[disabled].focus, fieldset[disabled] .btn-login.focus  { background-color: ' . $highlightColor . '; }
			.panel-login .panel-body { border-color: ' . $highlightColor . '; }
		';

		$background = $backendLoginSettings['style']['background'];
		if(preg_match('/^#[a-f0-9]{6}$/i', $background)) {
			$customCSS .= '.typo3-login { background-color: ' . $background . '; }';
		} else {
			$customCSS .= '.typo3-login { background-image: url("' . $background . '"); }';
		}

		$pageRenderer->addCssInlineBlock('tgm_customerservice', $customCSS);
		$view->assign('backendSettings', $backendLoginSettings);
	}

	/**
	 * Prüft, ob die Konfigurationsdatei existiert oder nicht und gibt den Inhalt als Array zurück.
	 * Wenn sie nicht existiert, werden die Standardwerte returned.
	 *
	 * @return array|mixed Das Array mit dem Inhalt der Konfigurationsdatei oder den Standardwerten.
	 */
	public static function getBackendLoginSettings() {
		$settings = [];
		/**
		 * Prüft, ob die Datei existiert oder nicht.
		 */
		if(file_exists(self::BACKEND_SETTINGS_FILE_PATH)) {
			$settings = json_decode(file_get_contents(self::BACKEND_SETTINGS_FILE_PATH), true);
		}
		return $settings;
	}
}