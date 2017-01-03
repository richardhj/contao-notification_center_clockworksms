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
 * Palettes
 */
$GLOBALS['TL_DCA'][$table]['palettes']['clockworksms'] = '{title_legend},title,gateway;{languages_legend},languages;{expert_legend:hide},clockwork_long,clockwork_truncate;{publish_legend},published';


/**
 * Fields
 */
$GLOBALS['TL_DCA'][$table]['fields']['clockwork_long'] = [
    'label'     => &$GLOBALS['TL_LANG'][$table]['clockwork_long'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => [
        'tl_class' => 'w50 m12',
    ],
    'sql'       => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$table]['fields']['clockwork_truncate'] = [
    'label'     => &$GLOBALS['TL_LANG'][$table]['clockwork_truncate'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => [
        'tl_class' => 'w50 m12',
    ],
    'sql'       => "char(1) NOT NULL default ''",
];
