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
$GLOBALS['TL_DCA']['tl_nc_message']['palettes']['clockworksms'] = '{title_legend},title,gateway;{languages_legend},languages;{expert_legend:hide},clockwork_long,clockwork_truncate;{publish_legend},published';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_nc_message']['fields']['clockwork_long'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_nc_message']['clockwork_long'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50 m12'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_nc_message']['fields']['clockwork_truncate'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_nc_message']['clockwork_truncate'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50 m12'),
    'sql'                     => "char(1) NOT NULL default ''"
);
