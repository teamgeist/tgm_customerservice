<?php

/***************************************************************
 * Extension config file for ext: "tgm_customerservice"
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF['tgm_customerservice'] = [
	'title' => 'TgM - Customer Service',
	'description' => 'A TYPO3-Extension to change your backend login-screen, add your company informations or change your backend icon. Everything in an own backend module. More features coming soon.',
	'category' => 'module',
	'author' => 'EG',
	'author_email' => 'eg@teamgeist-medien.de',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '1.0.2',
	'constraints' => [
		'depends' => [
			'php' => '7.0.0',
			'typo3' => '7.6.0-8.7.99',
		],
		'conflicts' => [],
		'suggests' => [],
	],
];