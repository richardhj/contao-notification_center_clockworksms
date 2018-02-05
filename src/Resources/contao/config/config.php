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

use Richardhj\NotificationCenterClockworkSmsBundle\Gateway\ClockworkSms;


/**
 * Notification Center Gateways
 */
$GLOBALS['NOTIFICATION_CENTER']['GATEWAY']['clockworksms'] = ClockworkSms::class;


/**
 * Notification Center Notification Types
 */
$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE'] = array_merge_recursive(
    (array)$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE'],
    [
        'contao' => [
            'core_form'           => [
                'sms_recipients'        => [
                    'form_*',
                ],
                'sms_recipients_region' => [
                    'form_*',
                ],
                'sms_text'              => [
                    'form_*',
                    'formconfig_*',
                    'raw_data',
                    'admin_email',
                ],
                'sms_sender'            => [
                    'form_*',
                ],
            ],
            'member_registration' => [
                'sms_recipients'        => [
                    'member_mobile',
                    'member_phone',
                ],
                'sms_recipients_region' => [
                    'member_country',
                ],
                'sms_text'              => [
                    'domain',
                    'link',
                    'member_*',
                    'admin_email',
                ],
                'sms_sender'            => [
                    'member_*',
                ],
            ],
            'member_personaldata' => [
                'sms_recipients'        => [
                    'member_mobile',
                    'member_phone',
                ],
                'sms_recipients_region' => [
                    'member_country',
                ],
                'sms_text'              => [
                    'domain',
                    'member_*',
                    'member_old_*',
                    'admin_email',
                ],
                'sms_sender'            => [
                    'member_*',
                ],
            ],
            'member_password'     => [
                'sms_recipients'        => [
                    'member_mobile',
                    'member_phone',
                ],
                'sms_recipients_region' => [
                    'member_country',
                ],
                'sms_text'              => [
                    'domain',
                    'link',
                    'member_*',
                    'admin_email',
                ],
                'sms_sender'            => [
                    'member_*',
                ],
            ],
        ],
    ]
);
