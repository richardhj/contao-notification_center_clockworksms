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
 * Palettes
 */
$GLOBALS['TL_DCA'][$table]['palettes']['clockworksms'] = '{title_legend},title,type;{gateway_legend},clockwork_api_key';


/**
 * Fields
 */
$GLOBALS['TL_DCA'][$table]['fields']['clockwork_api_key'] = [
    'label'     => &$GLOBALS['TL_LANG'][$table]['clockwork_api_key'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => [
        'mandatory' => true,
        'tl_class'  => 'w50',
    ],
    'sql'       => "varchar(64) NOT NULL default ''",
];
