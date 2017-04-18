<?php

namespace TgM\TgmCustomerservice\Controller;

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
 * AdministrationModuleController
 */
class AdministrationModuleController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * administrationModuleRepository
	 *
	 * @var \TgM\TgmCustomerservice\Domain\Repository\AdministrationModuleRepository
	 * @inject
	 */
	protected $administrationModuleRepository = null;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$administrationModules = $this->administrationModuleRepository->findAll();
		$this->view->assign('administrationModules', $administrationModules);
	}
}