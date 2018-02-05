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
$table = NotificationCenter\Model\Message::getTable();


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$table]['clockwork_long'][0] = 'Long SMS';
$GLOBALS['TL_LANG'][$table]['clockwork_long'][1] = 'Enable long SMS. A standard text can contain 160 characters, a long SMS supports up to 459.';
$GLOBALS['TL_LANG'][$table]['clockwork_truncate'][0] = 'Trim too long messages';
$GLOBALS['TL_LANG'][$table]['clockwork_truncate'][1] = 'When enabled, the message content is trimmed to the maximum length if it\'s too long. The SMS will not be sent due an error otherwise';
