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
