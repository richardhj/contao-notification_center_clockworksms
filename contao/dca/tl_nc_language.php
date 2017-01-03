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
 * Palettes
 */
$GLOBALS['TL_DCA'][$table]['palettes']['clockworksms'] = '{general_legend},language,fallback;{meta_legend},sms_sender,sms_recipients,sms_recipients_region;{content_legend},sms_text';


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
        ['NotificationCenter\Util\ClockworkSmsHelper', 'validateSmsSender'],
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
        ['NotificationCenter\Util\ClockworkSmsHelper', 'validatePhoneNumberList'],
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
        'sql'       => "text NULL",
    ];
