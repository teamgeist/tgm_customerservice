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

use TgMUtility;
use TYPO3\CMS\Backend\Controller\LoginController;
use TYPO3\CMS\Backend\LoginProvider\UsernamePasswordLoginProvider;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Registers login template for the current domain
 */
class LoginFormHook extends UsernamePasswordLoginProvider {

	/**
	 * Direkt-Pfad zur Datei
	 */
	const BACKEND_SETTINGS_FILE_PATH = TgMUtility::EXT_DIR_PATH . '/backendsettings.json';

	/**
	 * @param StandaloneView  $view
	 * @param PageRenderer    $pageRenderer
	 * @param LoginController $loginController
	 */
	public function render(StandaloneView $view, PageRenderer $pageRenderer, LoginController $loginController) {
		parent::render($view, $pageRenderer, $loginController);

		$backendSettings = self::getBackendLoginSettings();

		$view->setLayoutRootPaths([ExtensionManagementUtility::extPath(TgMUtility::EXT_KEY) . 'Resources/Private/Backend/Layouts']);
		$customCSS = '
			.btn-login, .btn-login:active, .btn-login:active:focus, .btn-login:active:hover,
			.btn-login:focus, .btn-login:hover, .btn-login:visited,				
			.btn-login.disabled:hover, .btn-login[disabled]:hover, fieldset[disabled] .btn-login:hover,
			.btn-login.disabled:focus, .btn-login[disabled]:focus, fieldset[disabled] .btn-login:focus,
			.btn-login.disabled.focus, .btn-login[disabled].focus, fieldset[disabled] .btn-login.focus  { background-color: ' . $backendSettings['style']['highlightColor'] . '; }
			.panel-login .panel-body { border-color: ' . $backendSettings['style']['highlightColor'] . '; }
		';

		// Login style
		$userBackground = $backendSettings['style']['background'];
		$loginCss = preg_match('/^#[a-f0-9]{6}$/i', $userBackground) ? 'background-color: ' . $userBackground . ';' : 'background-image: url("' . $userBackground . '");';
		$customCSS .= ' .typo3-login { ' . $loginCss . ' }';

		// Logo style
		$imageStyle = $backendSettings['style']['logo'] === 'sysext/backend/Resources/Public/Images/typo3_orange.svg' ? 'max-width: 150px;' : 'max-width: 100% !important;';
		$customCSS .= ' img.typo3-login-image { ' . $imageStyle . ' }';

		$pageRenderer->addCssInlineBlock('tgm_customerservice', $customCSS);
		$view->assign('backendSettings', $backendSettings);
	}

	/**
	 * Checks if the configuration file exists and returns it's content as an array.
	 * If it doesn't exist, it'll return an empty array.
	 *
	 * @return array The array with the given config values.
	 */
	public static function getBackendLoginSettings() {
		return file_exists(self::BACKEND_SETTINGS_FILE_PATH) ? json_decode(file_get_contents(self::BACKEND_SETTINGS_FILE_PATH), true) : [];
	}
}