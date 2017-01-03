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
$table = NotificationCenter\Model\Language::getTable();


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$table]['sms_sender'][0] = 'Absender';
$GLOBALS['TL_LANG'][$table]['sms_sender'][1] = 'Geben Sie einen Namen oder eine Telefonnummer ein, der als Absender erscheint.';
$GLOBALS['TL_LANG'][$table]['sms_recipients'][0] = 'Empfänger';
$GLOBALS['TL_LANG'][$table]['sms_recipients'][1] = 'Geben Sie kommagetrennt Telefonnummern der Empfänger ein.';
$GLOBALS['TL_LANG'][$table]['sms_recipients_region'][0] = 'Fallback-Ländercode der Empfänger';
$GLOBALS['TL_LANG'][$table]['sms_recipients_region'][1] = 'Wenn eine Telefonnummer ohne Länder-Präfix übergeben wird, wird die Telefonnummer mittels diesem Ländercode internationalisiert. Wenn die Empfänger sicher aus Deutschland kommen, geben Sie \'de\' ein. Leerlassen, um die Sprache dieser Nachricht als Fallback zu verwenden.';
$GLOBALS['TL_LANG'][$table]['sms_text'][0] = 'Textinhalt';
$GLOBALS['TL_LANG'][$table]['sms_text'][1] = 'Geben Sie den Textinhalt der SMS ein. Achten Sie dabei auf die Länge (vgl. Länge-Einstellung in der Nachricht).';
