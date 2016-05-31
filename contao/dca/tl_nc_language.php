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
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_nc_language']['palettes']['clockworksms'] = '{general_legend},language,fallback;{meta_legend},sms_sender,sms_recipients,sms_recipients_region;{content_legend},sms_text';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_nc_language']['fields']['sms_sender'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_nc_language']['sms_sender'],
	'exclude'   => true,
	'inputType' => 'text',
	'eval'      => array('rgxp' => 'nc_tokens', 'decodeEntities' => true, 'tl_class' => 'w50'),
	'sql'       => "varchar(255) NOT NULL default ''",
	'save_callback' => array
	(
		array('NotificationCenter\Util\ClockworkSmsHelper', 'validateSmsSender')
	)
);

$GLOBALS['TL_DCA']['tl_nc_language']['fields']['sms_recipients'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_nc_language']['sms_recipients'],
	'exclude'       => true,
	'inputType'     => 'text',
	'eval'          => array('rgxp' => 'nc_tokens', 'tl_class' => 'long clr', 'decodeEntities' => true, 'mandatory' => true),
	'sql'           => "varchar(255) NOT NULL default ''",
	'save_callback' => array
	(
		array('NotificationCenter\Util\ClockworkSmsHelper', 'validatePhoneNumberList')
	)
);

$GLOBALS['TL_DCA']['tl_nc_language']['fields']['sms_recipients_region'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_nc_language']['sms_recipients_region'],
	'exclude'       => true,
	'inputType'     => 'text',
	'eval'          => array('rgxp' => 'nc_tokens', 'tl_class' => 'w50', 'decodeEntities' => true),
	'sql'           => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_nc_language']['fields']['sms_text'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_nc_language']['sms_text'],
	'exclude'   => true,
	'inputType' => 'textarea',
	'eval'      => array('rgxp' => 'nc_tokens', 'tl_class' => 'clr', 'decodeEntities' => true, 'mandatory' => true),
	'sql'       => "text NULL"
);
