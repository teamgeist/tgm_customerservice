# Module configuration
module.tx_tgmcustomerservice {
	persistence {
		storagePid = {$module.tx_tgmcustomerservice_customermodule.persistence.storagePid}
	}

	view {
		templateRootPaths {
			0 = EXT:tgm_customerservice/Resources/Private/Backend/Templates/
		}

		partialRootPaths {
			0 = EXT:tgm_customerservice/Resources/Private/Backend/Partials/
		}

		layoutRootPaths {
			0 = EXT:tgm_customerservice/Resources/Private/Backend/Layouts/
		}
	}
}

# Module configuration
module.tx_tgmcustomerservice_tools_tgmcustomerserviceadministrationmodule {
	persistence {
		storagePid = {$module.tx_tgmcustomerservice_administrationmodule.persistence.storagePid}
	}

	view {
		templateRootPaths {
			0 = EXT:tgm_customerservice/Resources/Private/Backend/Templates/
			1 = {$module.tx_tgmcustomerservice_administrationmodule.view.templateRootPath}
		}

		partialRootPaths {
			0 = EXT:tgm_customerservice/Resources/Private/Backend/Partials/
			1 = {$module.tx_tgmcustomerservice_administrationmodule.view.partialRootPath}
		}

		layoutRootPaths {
			0 = EXT:tgm_customerservice/Resources/Private/Backend/Layouts/
			1 = {$module.tx_tgmcustomerservice_administrationmodule.view.layoutRootPath}
		}
	}
}