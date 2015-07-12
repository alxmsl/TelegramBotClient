<?php
/*
 * Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace alxmsl\Telegram\Bot;

use alxmsl\Network\Exception\HttpCodeException;
use alxmsl\Network\Http\Request;
use alxmsl\Telegram\Bot\Exception\UnsuccessfulException;
use alxmsl\Telegram\Bot\Type\Message;
use alxmsl\Telegram\Bot\Type\Update;
use alxmsl\Telegram\Bot\Type\User;
use alxmsl\Telegram\Bot\Type\UserProfilePhotos;
use Closure;
use CURLFile;
use JsonSerializable;
use stdClass;

/**
 * Telegram Bot API client
 * @author alxmsl
 */
class Client implements ClientInterface {
    /**
     * Telegram API endpoint
     */
    const ENDPOINT_URI = 'https://api.telegram.org';

    /**
     * @var string authentication token
     */
    private $token = '';

    /**
     * @var int connect timeout, seconds
     */
    private $connectTimeout = 0;

    /**
     * @var int request timeout, seconds
     */
    private $requestTimeout = 0;

    /**
     * @param int $connectTimeout connect timeout, seconds
     * @return $this
     */
    public function setConnectTimeout($connectTimeout) {
        $this->connectTimeout = (int) $connectTimeout;
        return $this;
    }

    /**
     * @return int connect timeout, seconds
     */
    public function getConnectTimeout() {
        return $this->connectTimeout;
    }

    /**
     * @param int $requestTimeout request timeout, seconds
     * @return $this
     */
    public function setRequestTimeout($requestTimeout) {
        $this->requestTimeout = (int) $requestTimeout;
        return $this;
    }

    /**
     * @return int request timeout, seconds
     */
    public function getRequestTimeout() {
        return $this->requestTimeout;
    }

    /**
     * @param string $token client authentication token
     */
    public function __construct($token = '') {
        $this->token = (string) $token;
    }

    /**
     * @inheritdoc
     */
    public function getMe() {
        return $this->getResult('getMe', [], function(stdClass $User) {
            return User::initializeByObject($User);
        });
    }

    /**
     * @inheritdoc
     */
    public function sendMessage($chatId, $text, $disableWebPagePreview = null, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $parameters = [
            'chat_id' => (int) $chatId,
            'text'    => (string) $text,
        ];
        if (!is_null($disableWebPagePreview)) {
            $parameters['disable_web_page_preview'] = (bool) $disableWebPagePreview;
        }
        if (!is_null($replyToMessageId)) {
            $parameters['reply_to_message_id'] = (int) $replyToMessageId;
        }
        if (!is_null($ReplyMarkUp)) {
            $parameters['reply_markup'] = json_encode($ReplyMarkUp);
        }
        return $this->getResult('sendMessage', $parameters, function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

    /**
     * @inheritdoc
     */
    public function forwardMessage($chatId, $fromChatId, $messageId) {
        return $this->getResult('forwardMessage', [
            'chat_id'      => (int) $chatId,
            'from_chat_id' => (int) $fromChatId,
            'message_id'   => (int) $messageId,
        ], function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

    /**
     * @inheritdoc
     */
    public function sendPhoto($chatId, $Photo, $caption = '', $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $parameters = [
            'chat_id' => (int) $chatId,
            'photo'   => $Photo,
        ];
        if (!empty($caption)) {
            $parameters['caption'] = (bool) $caption;
        }
        if (!is_null($replyToMessageId)) {
            $parameters['reply_to_message_id'] = (int) $replyToMessageId;
        }
        if (!is_null($ReplyMarkUp)) {
            $parameters['reply_markup'] = json_encode($ReplyMarkUp);
        }
        return $this->getResult('sendPhoto', $parameters, function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

    /**
     * @inheritdoc
     */
    public function sendPhotoByFileId($chatId, $fileId, $caption = '', $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        return $this->sendPhoto($chatId, (string) $fileId, $caption, $replyToMessageId, $ReplyMarkUp);
    }

    /**
     * @inheritdoc
     */
    public function sendPhotoFile($chatId, $fileName, $caption = '', $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $File = new CURLFile($fileName);
        return $this->sendPhoto($chatId, $File, $caption, $replyToMessageId, $ReplyMarkUp);
    }

    /**
     * @inheritdoc
     */
    public function sendAudio($chatId, $Audio, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $parameters = [
            'chat_id' => (int) $chatId,
            'audio'   => $Audio,
        ];
        if (!is_null($replyToMessageId)) {
            $parameters['reply_to_message_id'] = (int) $replyToMessageId;
        }
        if (!is_null($ReplyMarkUp)) {
            $parameters['reply_markup'] = json_encode($ReplyMarkUp);
        }
        return $this->getResult('sendAudio', $parameters, function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

    /**
     * @inheritdoc
     */
    public function sendAudioByFileId($chatId, $fileId, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        return $this->sendAudio($chatId, (string) $fileId, $replyToMessageId, $ReplyMarkUp);
    }

    /**
     * @inheritdoc
     */
    public function sendAudioByFileName($chatId, $fileName, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $File = new CURLFile($fileName);
        return $this->sendAudio($chatId, $File, $replyToMessageId, $ReplyMarkUp);
    }

    /**
     * @inheritdoc
     */
    public function sendDocument($chatId, $Document, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $parameters = [
            'chat_id'  => (int) $chatId,
            'document' => $Document,
        ];
        if (!is_null($replyToMessageId)) {
            $parameters['reply_to_message_id'] = (int) $replyToMessageId;
        }
        if (!is_null($ReplyMarkUp)) {
            $parameters['reply_markup'] = json_encode($ReplyMarkUp);
        }
        return $this->getResult('sendDocument', $parameters, function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

    /**
     * @inheritdoc
     */
    public function sendDocumentByFileId($chatId, $fileId, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        return $this->sendDocument($chatId, (string) $fileId, $replyToMessageId, $ReplyMarkUp);
    }

    /**
     * @inheritdoc
     */
    public function sendDocumentByFileName($chatId, $fileName, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $File = new CURLFile($fileName);
        return $this->sendDocument($chatId, $File, $replyToMessageId, $ReplyMarkUp);
    }

    /**
     * @inheritdoc
     */
    public function sendSticker($chatId, $Sticker, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $parameters = [
            'chat_id' => (int) $chatId,
            'sticker'   => $Sticker,
        ];
        if (!is_null($replyToMessageId)) {
            $parameters['reply_to_message_id'] = (int) $replyToMessageId;
        }
        if (!is_null($ReplyMarkUp)) {
            $parameters['reply_markup'] = json_encode($ReplyMarkUp);
        }
        return $this->getResult('sendSticker', $parameters, function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

    /**
     * @inheritdoc
     */
    public function sendStickerByFileId($chatId, $fileId, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        return $this->sendsticker($chatId, (string) $fileId, $replyToMessageId, $ReplyMarkUp);
    }

    /**
     * @inheritdoc
     */
    public function sendStickerByFileName($chatId, $fileName, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $File = new CURLFile($fileName);
        return $this->sendsticker($chatId, $File, $replyToMessageId, $ReplyMarkUp);
    }

    /**
     * @inheritdoc
     */
    public function sendVideo($chatId, $Video, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $parameters = [
            'chat_id' => (int) $chatId,
            'video'   => $Video,
        ];
        if (!is_null($replyToMessageId)) {
            $parameters['reply_to_message_id'] = (int) $replyToMessageId;
        }
        if (!is_null($ReplyMarkUp)) {
            $parameters['reply_markup'] = json_encode($ReplyMarkUp);
        }
        return $this->getResult('sendVideo', $parameters, function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

    /**
     * @inheritdoc
     */
    public function sendVideoByFileId($chatId, $fileId, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        return $this->sendvideo($chatId, (string) $fileId, $replyToMessageId, $ReplyMarkUp);
    }

    /**
     * @inheritdoc
     */
    public function sendVideoByFileName($chatId, $fileName, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $File = new CURLFile($fileName);
        return $this->sendvideo($chatId, $File, $replyToMessageId, $ReplyMarkUp);
    }

    /**
     * @inheritdoc
     */
    public function sendLocation($chatId, $latitude, $longitude, $replyToMessageId = null, JsonSerializable $ReplyMarkUp = null) {
        $parameters = [
            'chat_id'   => (int) $chatId,
            'latitude'  => (float) $latitude,
            'longitude' => (float) $longitude,
        ];
        if (!is_null($replyToMessageId)) {
            $parameters['reply_to_message_id'] = (int) $replyToMessageId;
        }
        if (!is_null($ReplyMarkUp)) {
            $parameters['reply_markup'] = json_encode($ReplyMarkUp);
        }
        return $this->getResult('sendLocation', $parameters, function(stdClass $Message) {
            return Message::initializeByObject($Message);
        });
    }

    /**
     * @inheritdoc
     */
    public function sendChatAction($chatId, $action) {
        return $this->getResult('sendChatAction', [
            'chat_id' => (int) $chatId,
            'action'  => (string) $action,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getUserProfilePhotos($userId, $offset = null, $limit = null) {
        $parameters = [
            'user_id' => (int) $userId,
        ];
        if (!is_null($offset)) {
            $parameters['offset'] = (int) $offset;
        }
        if (!is_null($limit)) {
            $parameters['limit'] = (int) $limit;
        }
        return $this->getResult('getUserProfilePhotos', $parameters, function(stdClass $Photos) {
            return UserProfilePhotos::initializeByObject($Photos);
        });
    }

    /**
     * @inheritdoc
     */
    public function getUpdates($offset = null, $limit = null, $timeout = null) {
        $parameters = [];
        if (!is_null($offset)) {
            $parameters['offset'] = (int) $offset;
        }
        if (!is_null($limit)) {
            $parameters['limit'] = (int) $limit;
        }
        if (!is_null($timeout)) {
            $parameters['timeout'] = (int) $timeout;
        }
        return $this->getResult('getUpdates', $parameters, function(stdClass $UpdateObject) {
            return Update::initializeByObject($UpdateObject);
        });
    }

    /**
     * @inheritdoc
     */
    public function setWebhook($url) {
        return $this->getResult('setWebhook', [
            'url' => $url,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function removeWebhook() {
        return $this->setWebhook('');
    }

    /**
     * Call bot method and return result instance
     * @param string $methodName API method name
     * @param array $parameters method call parameters
     * @param Closure|null $BuildStrategy build strategy for response result(s)
     * @return mixed response result instance
     * @throws UnsuccessfulException exception for unsuccessful request responses
     */
    private function getResult($methodName, array $parameters = [], Closure $BuildStrategy = null) {
        $responseData = $this->call($methodName, $parameters);
        $Response     = Response::initializeByString($responseData, $BuildStrategy);
        if (!$Response->isOk()) {
            throw new UnsuccessfulException($Response->getDescription(), $Response->getErrorCode());
        } else {
            return $Response->getResult();
        }
    }

    /**
     * Call bot method
     * @param string $methodName API method name
     * @param array $parameters method call parameters
     * @return string response data
     * @codeCoverageIgnore
     */
    public function call($methodName, array $parameters = []) {
        try {
            return $this->getRequest($methodName, $parameters)->send();
        } catch (HttpCodeException $Ex) {
            return $Ex->getMessage();
        }
    }

    /**
     * Create request for method call
     * @param string $methodName API method name
     * @param array $parameters method call parameters
     * @return Request request object
     */
    private function getRequest($methodName, array $parameters = []) {
        $Request = new Request();
        $Request->setTransport(Request::TRANSPORT_CURL);
        $Request->setUrl(self::ENDPOINT_URI)
            ->setConnectTimeout($this->getConnectTimeout())
            ->setTimeout($this->getRequestTimeout())
            ->addUrlField(sprintf('bot%s', $this->token), $methodName);
        if (!empty($parameters)) {
            $Request->setPostData($parameters);
        }
        return $Request;
    }
}
