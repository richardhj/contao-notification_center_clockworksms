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
