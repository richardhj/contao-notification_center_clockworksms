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

use Richardhj\NotificationCenterClockworkSmsBundle\Util\ClockworkSmsHelper;


/** @noinspection PhpUndefinedMethodInspection */
$table = NotificationCenter\Model\Language::getTable();


/**
 * Palettes
 */
$GLOBALS['TL_DCA'][$table]['palettes']['clockworksms'] =
    '{general_legend},language,fallback;{meta_legend},sms_sender,sms_recipients,sms_recipients_region;{content_legend},sms_text';


/**
 * Fields
 */
$GLOBALS['TL_DCA'][$table]['fields']['sms_sender'] = [
    'label'         => &$GLOBALS['TL_LANG'][$table]['sms_sender'],
    'exclude'       => true,
    'inputType'     => 'text',
    'eval'          => [
        'rgxp'           => 'nc_tokens',
        'decodeEntities' => true,
        'tl_class'       => 'w50',
    ],
    'save_callback' => [
        [ClockworkSmsHelper::class, 'validateSmsSender'],
    ],
    'sql'           => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$table]['fields']['sms_recipients'] = [
    'label'         => &$GLOBALS['TL_LANG'][$table]['sms_recipients'],
    'exclude'       => true,
    'inputType'     => 'text',
    'eval'          => [
        'rgxp'           => 'nc_tokens',
        'tl_class'       => 'long clr',
        'decodeEntities' => true,
        'mandatory'      => true,
    ],
    'save_callback' => [
        [ClockworkSmsHelper::class, 'validatePhoneNumberList'],
    ],
    'sql'           => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$table]['fields']['sms_recipients_region'] =
    [
        'label'     => &$GLOBALS['TL_LANG'][$table]['sms_recipients_region'],
        'exclude'   => true,
        'inputType' => 'text',
        'eval'      => [
            'rgxp'           => 'nc_tokens',
            'tl_class'       => 'w50',
            'decodeEntities' => true,
        ],
        'sql'       => "varchar(255) NOT NULL default ''",
    ];

$GLOBALS['TL_DCA'][$table]['fields']['sms_text'] =
    [
        'label'     => &$GLOBALS['TL_LANG'][$table]['sms_text'],
        'exclude'   => true,
        'inputType' => 'textarea',
        'eval'      => [
            'rgxp'           => 'nc_tokens',
            'tl_class'       => 'clr',
            'decodeEntities' => true,
            'mandatory'      => true,
        ],
        'sql'       => 'text NULL',
    ];
