<?php
/**
 * Clockwork SMS gateway for the notification_center extension for Contao Open Source CMS
 *
 * Copyright (c) 2016-2017 Richard Henkenjohann
 *
 * @package NotificationCenterClockworkSMS
 * @author  Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


/**
 * Notification Center Gateways
 */
$GLOBALS['NOTIFICATION_CENTER']['GATEWAY']['clockworksms'] = 'NotificationCenter\Gateway\ClockworkSms';


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
