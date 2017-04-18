<?php
if(!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// TODO: Überschreibt andere Extensions, die einen Backend-Login-Hook nutzen
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['backend']['loginProviders'][1433416747]['provider'] = TgM\TgmCustomerservice\Hook\LoginFormHook::class;