<?php
/**
 * Clockwork SMS gateway for the notification_center extension for Contao Open Source CMS
 *
 * Copyright (c) 2016-2017 Richard Henkenjohann
 *
 * @package NotificationCenterClockworkSMS
 * @author  Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


/** @noinspection PhpUndefinedMethodInspection */
$table = NotificationCenter\Model\Gateway::getTable();


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$table]['clockwork_api_key'][0] = 'Clockwork API Key';
$GLOBALS['TL_LANG'][$table]['clockwork_api_key'][1] = 'Enter your Clockwork API Key. Login at <a href="https://www.clockworksms.com" target="_blank">clockworksms.com</a> therefore.';


/**
 * Types
 */
$GLOBALS['TL_LANG'][$table]['type']['clockworksms'] = 'Clockwork SMS';
