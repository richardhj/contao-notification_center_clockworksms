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
$GLOBALS['TL_LANG'][$table]['clockwork_long'][0] = 'Lange SMS';
$GLOBALS['TL_LANG'][$table]['clockwork_long'][1] = 'Aktivieren Sie lange SMS. Eine Standard-SMS kann 160 Zeichen enthalten, eine lange SMS bis zu 459.';
$GLOBALS['TL_LANG'][$table]['clockwork_truncate'][0] = 'Zu langen Text abschneiden';
$GLOBALS['TL_LANG'][$table]['clockwork_truncate'][1] = 'Wählen Sie, ob zu langer Text in der SMS abgeschnitten werden soll oder ob die SMS andernfalls wegen eines Fehlers nicht versendet werden soll.';
