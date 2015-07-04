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

namespace alxmsl\Telegram\Bot\Type;

use alxmsl\Telegram\Bot\ObjectInitializedInterface;
use stdClass;

/**
 * Class for incoming update
 * @author alxmsl
 */
final class Update implements ObjectInitializedInterface {
    /**
     * @var int update unique identifier
     */
    private $updateId = 0;

    /**
     * @return int update unique identifier
     */
    public function getUpdateId() {
        return $this->updateId;
    }

    /**
     * @param int $updateId update unique identifier
     * @return $this self
     */
    public function setUpdateId($updateId) {
        $this->updateId = (int) $updateId;
        return $this;
    }

    /**
     * @var null|Message update message
     */
    private $Message = null;

    /**
     * @return Message|null update message
     */
    public function getMessage() {
        return $this->Message;
    }

    /**
     * @param Message|null $Message update message
     * @return $this self instance
     */
    public function setMessage($Message) {
        $this->Message = $Message;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function initializeByObject(stdClass $Object) {
        $Update = new self();
        $Update->setUpdateId($Object->update_id);
        if (isset($Object->message)) {
            $Update->setMessage(Message::initializeByObject($Object->message));
        }
        return $Update;
    }
}
