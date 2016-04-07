<?php
/**
 * Clockwork SMS gateway for the notification_center extension for Contao Open Source CMS
 *
 * Copyright (c) 2016 Richard Henkenjohann
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
	array(
		'contao' => array(
			'core_form'           => array(
				'sms_recipients'        => array('form_*'),
				'sms_recipients_region' => array('form_*'),
				'sms_text'              => array('form_*', 'formconfig_*', 'raw_data', 'admin_email'),
				'sms_sender'            => array('form_*'),
			),
			'member_registration' => array(
				'sms_recipients'        => array('member_mobile', 'member_phone'),
				'sms_recipients_region' => array('member_country'),
				'sms_text'              => array('domain', 'link', 'member_*', 'admin_email'),
				'sms_sender'            => array('member_*'),
			),
			'member_personaldata' => array(
				'sms_recipients'        => array('member_mobile', 'member_phone'),
				'sms_recipients_region' => array('member_country'),
				'sms_text'              => array('domain', 'member_*', 'member_old_*', 'admin_email'),
				'sms_sender'            => array('member_*'),
			),
			'member_password'     => array(
				'sms_recipients'        => array('member_mobile', 'member_phone'),
				'sms_recipients_region' => array('member_country'),
				'sms_text'              => array('domain', 'link', 'member_*', 'admin_email'),
				'sms_sender'            => array('member_*'),
			)
		)
	)
);
