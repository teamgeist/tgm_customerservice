<?php
return [
	'ctrl' => [
		'title' => 'LLL:EXT:tgm_customerservice/Resources/Private/Language/locallang_db.xlf:tx_tgmcustomerservice_domain_model_administrationmodule',
		'label' => 'uid',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => true,
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime'
		],
		'searchFields' => '',
		'iconfile' => 'EXT:tgm_customerservice/Resources/Public/Icons/tx_tgmcustomerservice_domain_model_administrationmodule.gif'
	],
	'interface' => ['showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, '],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, , --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime']
	],
	'columns' => [
		'sys_language_uid' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'special' => 'languages',
				'default' => 0,
				'items' => [
					['LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1, 'flags-multiple']
				]
			]
		],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_tgmcustomerservice_domain_model_administrationmodule',
				'foreign_table_where' => 'AND tx_tgmcustomerservice_domain_model_administrationmodule.pid=###CURRENT_PID### AND tx_tgmcustomerservice_domain_model_administrationmodule.sys_language_uid IN (-1,0)',
				'items' => [
					['', 0]
				]
			]
		],
		'l10n_diffsource' => [
			'config' => ['type' => 'passthrough']
		],
		't3ver_label' => [
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255
			]
		],
		'hidden' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => [
				'type' => 'check',
				'items' => [
					'1' => ['0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled']
				]
			]
		],
		'starttime' => [
			'exclude' => true,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => [
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime',
				'default' => 0
			]
		],
		'endtime' => [
			'exclude' => true,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => [
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime',
				'default' => 0,
				'range' => ['upper' => mktime(0, 0, 0, 1, 1, 2038)]
			]
		]
	]
];
