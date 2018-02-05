<?php

/**
 * This file is part of richardhj/contao-notification_center_clockworksms.
 *
 * Copyright (c) 2016-2018 Richard Henkenjohann
 *
 * @package   richardhj/contao-notification_center_member_selectable
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @copyright 2016-2018 Richard Henkenjohann
 * @license   https://github.com/richardhj/contao-notification_center_member_selectable/blob/master/LICENSE LGPL-3.0
 */

namespace Richardhj\NotificationCenterClockworkSmsBundle\Gateway;

use Contao\MemberModel;
use mediaburst\ClockworkSMS\Clockwork;
use mediaburst\ClockworkSMS\ClockworkException;
use NotificationCenter\Gateway\Base;
use NotificationCenter\Gateway\GatewayInterface;
use NotificationCenter\Gateway\MessageDraftCheckSendInterface;
use NotificationCenter\MessageDraft\MessageDraftFactoryInterface;
use NotificationCenter\MessageDraft\MessageDraftInterface;
use NotificationCenter\Model\Gateway;
use NotificationCenter\Model\Language;
use NotificationCenter\Model\Message;
use Richardhj\NotificationCenterClockworkSmsBundle\MessageDraft\ClockworkSmsMessageDraft;


/**
 * Class ClockworkSms
 *
 * @package NotificationCenter\Gateway
 */
class ClockworkSms extends Base
    implements GatewayInterface, MessageDraftFactoryInterface, MessageDraftCheckSendInterface
{

    /**
     * The gateway model
     *
     * @var Gateway|\Model
     */
    protected $objModel;


    /**
     * Returns a MessageDraft
     *
     * @param   Message|\Model $message
     * @param   array          $tokens
     * @param   string         $language
     *
     * @return  MessageDraftInterface|null (if no draft could be found)
     */
    public function createDraft(Message $message, array $tokens, $language = '')
    {
        if ('' === $language) {
            $language = $GLOBALS['TL_LANGUAGE'];
        }

        if (null === ($objLanguage = Language::findByMessageAndLanguageOrFallback($message, $language))) {
            \System::log(
                sprintf(
                    'Could not find matching language or fallback for message ID "%s" and language "%s".',
                    $message->id,
                    $language
                ),
                __METHOD__,
                TL_ERROR
            );

            return null;
        }

        return new ClockworkSmsMessageDraft($message, $objLanguage, $tokens);
    }


    /**
     * Send Clockwork request message
     *
     * @param   Message|\Model $message
     * @param   array          $tokens
     * @param   string         $language
     *
     * @return  bool
     */
    public function send(Message $message, array $tokens, $language = '')
    {
        if ('' === $this->objModel->clockwork_api_key) {
            \System::log(
                sprintf('Please provide the Clockwork API key for message ID "%s"', $message->id),
                __METHOD__,
                TL_ERROR
            );

            return false;
        }

        /** @var ClockworkSmsMessageDraft $draft */
        $draft = $this->createDraft($message, $tokens, $language);

        // return false if no language found for BC
        if (null === $draft) {
            return false;
        }

        $messages = [];

        $clockwork = new Clockwork(
            $this->objModel->clockwork_api_key, [
                'from'     => $draft->getFrom(),
                'long'     => (bool)$message->long,
                'truncate' => (bool)$message->truncate,
            ]
        );

        foreach ($draft->getRecipients() as $recipient) {
            $messages[] = [
                'to'      => $recipient,
                'message' => $draft->getText(),
            ];
        }

        try {
            $result = $clockwork->send($messages);

        } catch (ClockworkException $e) {
            \System::log(
                sprintf(
                    'Error with message "%s" (Code %s) while sending the Clockwork request for message ID "%s" occurred.',
                    $e->getMessage(),
                    $e->getCode(),
                    $message->id
                ),
                __METHOD__,
                TL_ERROR
            );

            return false;
        }

        $blnError = false;

        foreach ((array)$result as $msg) {
            if (!$msg['success']) {
                \System::log(
                    sprintf(
                        'Error with message "%s" (Code %s) while sending the Clockwork request for message ID "%s" occurred.',
                        $msg['error_message'],
                        $msg['error_code'],
                        $message->id
                    ),
                    __METHOD__,
                    TL_ERROR
                );

                $blnError = true;
            }
        }

        return !$blnError;
    }


    /**
     * {@inheritdoc}
     */
    public function canSendDraft(Message $message)
    {
        // Create a dummy draft
        // All drafts get the member data as tokens with "member_" prefix. We imitate it here
        /** @var MemberModel|\Model $memberModel */
        $memberModel = MemberModel::findByPk(\FrontendUser::getInstance()->id);
        /** @var ClockworkSmsMessageDraft $draft */
        $draft = $this->createDraft(
            $message,
            array_combine
            (
                array_map(
                    function ($key) {
                        return 'member_'.$key;
                    },
                    array_keys($memberModel->row())
                ),
                $memberModel->row()
            )
        );

        $recipients = $draft->getRecipients();

        if (empty($recipients)) {
            throw new \LogicException($GLOBALS['TL_LANG']['ERR']['clockworkDraftCanNotSend']);
        }

        return true;
    }
}
