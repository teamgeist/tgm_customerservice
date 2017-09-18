module.tx_tgmcustomerservice_administrationmodule {
	view {
		# cat=TGM_CUSTOMERSERVICE - ADMINISTRATION/file; type=string; label=Path to template root (BE)
		templateRootPath = EXT:tgm_customerservice/Resources/Private/Backend/Templates/
		# cat=TGM_CUSTOMERSERVICE - ADMINISTRATION/file; type=string; label=Path to template partials (BE)
		partialRootPath = EXT:tgm_customerservice/Resources/Private/Backend/Partials/
		# cat=TGM_CUSTOMERSERVICE - ADMINISTRATION/file; type=string; label=Path to template layouts (BE)
		layoutRootPath = EXT:tgm_customerservice/Resources/Private/Backend/Layouts/AdministrationModule/
	}

	persistence {
		# cat=TGM_CUSTOMERSERVICE - ADMINISTRATION//a; type=string; label=Default storage PID
		storagePid =
	}
}
