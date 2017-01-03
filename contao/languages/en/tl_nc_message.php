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
$table = NotificationCenter\Model\Message::getTable();


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$table]['clockwork_long'][0] = 'Long SMS';
$GLOBALS['TL_LANG'][$table]['clockwork_long'][1] = 'Enable long SMS. A standard text can contain 160 characters, a long SMS supports up to 459.';
$GLOBALS['TL_LANG'][$table]['clockwork_truncate'][0] = 'Trim too long messages';
$GLOBALS['TL_LANG'][$table]['clockwork_truncate'][1] = 'When enabled, the message content is trimmed to the maximum length if it\'s too long. The SMS will not be sent due an error otherwise';
