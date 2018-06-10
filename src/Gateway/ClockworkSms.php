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

use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\MemberModel;
use Contao\System;
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
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param Gateway $model
     */
    public function __construct(Gateway $model)
    {
        parent::__construct($model);

        $this->logger = System::getContainer()->get('monolog.logger.contao');
    }

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
            $this->logger->log(
                LogLevel::ERROR,
                sprintf(
                    'Could not find matching language or fallback for message ID "%s" and language "%s".',
                    $message->id,
                    $language
                ),
                array('contao' => new ContaoContext(__METHOD__, TL_ERROR))
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
     *
     * @throws ClockworkException If api key is not set
     */
    public function send(Message $message, array $tokens, $language = '')
    {
        if ('' === $this->objModel->clockwork_api_key) {
            $this->logger->log(
                LogLevel::ERROR,
                sprintf('Please provide the Clockwork API key for message ID "%s"', $message->id),
                array('contao' => new ContaoContext(__METHOD__, TL_ERROR))
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
            $this->objModel->clockwork_api_key,
            [
                'from'     => $draft->getFrom(),
                'long'     => (bool) $message->long,
                'truncate' => (bool) $message->truncate,
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
            $this->logger->log(
                LogLevel::ERROR,
                sprintf(
                    'Error with message "%s" (Code %s) while sending the Clockwork request for message ID "%s" occurred.',
                    $e->getMessage(),
                    $e->getCode(),
                    $message->id
                ),
                array('contao' => new ContaoContext(__METHOD__, TL_ERROR))
            );

            return false;
        }

        $blnError = false;

        foreach ((array) $result as $msg) {
            if (!$msg['success']) {
                $this->logger->log(
                    LogLevel::ERROR,
                    sprintf(
                        'Error with message "%s" (Code %s) while sending the Clockwork request for message ID "%s" occurred.',
                        $msg['error_message'],
                        $msg['error_code'],
                        $message->id
                    ),
                    array('contao' => new ContaoContext(__METHOD__, TL_ERROR))
                );

                $blnError = true;
            }
        }

        return !$blnError;
    }


    /**
     * Check whether an exemplary draft can be send by means of a given message and gateway. In most cases this check
     * looks for existing recipients
     *
     * @param Message $objMessage
     *
     * @return bool
     *
     * @throws \LogicException Optional with an error message
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
                        return 'member_' . $key;
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
