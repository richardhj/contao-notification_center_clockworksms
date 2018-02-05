<?php

/**
 * This file is part of richardhj/contao-notification_center_clockworksms.
 *
 * Copyright (c) 2016-2018 Richard Henkenjohann
 *
 * @package   richardhj/contao-notification_center_clockworksms
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @copyright 2016-2018 Richard Henkenjohann
 * @license   https://github.com/richardhj/contao-notification_center_clockworksms/blob/master/LICENSE LGPL-3.0
 */


/** @noinspection PhpUndefinedMethodInspection */
$table = NotificationCenter\Model\Language::getTable();


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$table]['sms_sender'][0] = 'Sender';
$GLOBALS['TL_LANG'][$table]['sms_sender'][1] = 'Enter the name or phone number that is shown as sender.';
$GLOBALS['TL_LANG'][$table]['sms_recipients'][0] = 'Recipients';
$GLOBALS['TL_LANG'][$table]['sms_recipients'][1] = 'Enter comma delimited phone numbers the message should be sent to.';
$GLOBALS['TL_LANG'][$table]['sms_recipients_region'][0] = 'Fallback recipient\'s region code';
$GLOBALS['TL_LANG'][$table]['sms_recipients_region'][1] = 'Enter the region\'s code that we are expecting the number to be from. This is only used if the given number is not in international format. If your recipients come from Germany, you should enter \'de\'. Keep empty to use the message\'s language as fallback';
$GLOBALS['TL_LANG'][$table]['sms_text'][0] = 'Text content';
$GLOBALS['TL_LANG'][$table]['sms_text'][1] = 'Enter the text content of the SMS. Keep an eye on the length.';
