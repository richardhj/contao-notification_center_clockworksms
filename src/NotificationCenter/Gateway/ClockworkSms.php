<?php
/**
 * Clockwork SMS gateway for the notification_center extension for Contao Open Source CMS
 *
 * Copyright (c) 2016 Richard Henkenjohann
 *
 * @package NotificationCenterClockworkSMS
 * @author  Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */

namespace NotificationCenter\Gateway;

use NotificationCenter\MessageDraft\ClockworkSmsMessageDraft;
use NotificationCenter\MessageDraft\MessageDraftFactoryInterface;
use NotificationCenter\MessageDraft\MessageDraftInterface;
use NotificationCenter\MessageDraft\PostmarkMessageDraft;
use NotificationCenter\Model\Gateway;
use NotificationCenter\Model\Language;
use NotificationCenter\Model\Message;


/**
 * Class ClockworkSms
 * @package NotificationCenter\Gateway
 */
class ClockworkSms extends Base implements GatewayInterface, MessageDraftFactoryInterface
{

	/**
	 * The gateway model
	 * @var Gateway|\Model
	 */
	protected $objModel;


	/**
	 * Returns a MessageDraft
	 *
	 * @param   Message|\Model $objMessage
	 * @param   array          $arrTokens
	 * @param   string         $strLanguage
	 *
	 * @return  MessageDraftInterface|null (if no draft could be found)
	 */
	public function createDraft(Message $objMessage, array $arrTokens, $strLanguage = '')
	{
		if ($strLanguage == '')
		{
			$strLanguage = $GLOBALS['TL_LANGUAGE'];
		}

		if (($objLanguage = Language::findByMessageAndLanguageOrFallback($objMessage, $strLanguage)) === null)
		{
			\System::log(sprintf('Could not find matching language or fallback for message ID "%s" and language "%s".', $objMessage->id, $strLanguage), __METHOD__, TL_ERROR);

			return null;
		}

		return new ClockworkSmsMessageDraft($objMessage, $objLanguage, $arrTokens);
	}

	/**
	 * Send Clockwork request message
	 *
	 * @param   Message|\Model $objMessage
	 * @param   array          $arrTokens
	 * @param   string         $strLanguage
	 *
	 * @return  bool
	 */
	public function send(Message $objMessage, array $arrTokens, $strLanguage = '')
	{
		if ($this->objModel->clockwork_api_key == '')
		{
			\System::log(sprintf('Please provide the Clockwork API key for message ID "%s"', $objMessage->id), __METHOD__, TL_ERROR);

			return false;
		}

		/** @var ClockworkSmsMessageDraft $objDraft */
		$objDraft = $this->createDraft($objMessage, $arrTokens, $strLanguage);

		// return false if no language found for BC
		if ($objDraft === null)
		{
			return false;
		}

		$arrMessages = array();

		//@todo We're waiting for a proper official composer integration of Clockwork. While so, a fork (used below) does it too
		$objClockwork = new \Clockwork($this->objModel->clockwork_api_key, array
		(
			'from'     => $objDraft->getFrom(),
			'long'     => (bool)$objMessage->long,
			'truncate' => (bool)$objMessage->truncate,
		));

		foreach ($objDraft->getRecipients() as $recipient)
		{
			$arrMessages[] = array
			(
				'to'      => $recipient,
				'message' => $objDraft->getText()
			);
		}

		try
		{
			$result = $objClockwork->send($arrMessages);

		} catch (\ClockworkException $e)
		{
			\System::log(sprintf('Error with message "%s" (Code %s) while sending the Clockwork request for message ID "%s" occurred.',
				$e->getMessage(),
				$e->getCode(),
				$objMessage->id
			), __METHOD__, TL_ERROR);

			return false;
		}

		$blnError = false;

		foreach ($result as $message)
		{
			if (!$message['success'])
			{
				\System::log(sprintf('Error with message "%s" (Code %s) while sending the Clockwork request for message ID "%s" occurred.',
					$message['error_message'],
					$message['error_code'],
					$objMessage->id
				), __METHOD__, TL_ERROR);

				$blnError = true;
			}
		}

		return !$blnError;
	}
}
