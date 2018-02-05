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
$table = NotificationCenter\Model\Gateway::getTable();


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$table]['clockwork_api_key'][0] = 'Clockwork API Key';
$GLOBALS['TL_LANG'][$table]['clockwork_api_key'][1] = 'Geben Sie den API Key ein. Ggf. müssen Sie sich auf <a href="https://www.clockworksms.com" target="_blank">clockworksms.com</a> registrieren.';


/**
 * Types
 */
$GLOBALS['TL_LANG'][$table]['type']['clockworksms'] = 'Clockwork SMS';
