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
$GLOBALS['TL_DCA']['tl_nc_gateway']['palettes']['clockworksms'] = '{title_legend},title,type;{gateway_legend},clockwork_api_key';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['clockwork_api_key'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_nc_gateway']['clockwork_api_key'],
	'exclude'   => true,
	'inputType' => 'text',
	'eval'      => array('mandatory' => true, 'tl_class' => 'w50'),
	'sql'       => "varchar(64) NOT NULL default ''"
);
